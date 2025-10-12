<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model
{
    protected $table = 'forms';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'slug',
        'description',
        'is_active',
        'success_message',
        'created_by',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'slug' => 'permit_empty|min_length[3]|max_length[255]|alpha_dash',
        'description' => 'permit_empty',
        'is_active' => 'permit_empty',
        'success_message' => 'permit_empty',
        'created_by' => 'required|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Form title is required',
            'min_length' => 'Title must be at least 3 characters long',
            'max_length' => 'Title cannot exceed 255 characters'
        ],
        'slug' => [
            'required' => 'Form slug is required',
            'min_length' => 'Slug must be at least 3 characters long',
            'max_length' => 'Slug cannot exceed 255 characters',
            'is_unique' => 'This slug is already in use',
            'alpha_dash' => 'Slug can only contain letters, numbers, dashes and underscores'
        ],
        'created_by' => [
            'required' => 'Creator is required',
            'integer' => 'Creator must be a valid user ID'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['title']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = $this->createSlug($data['data']['title']);
        }
        
        // Ensure slug uniqueness
        if (isset($data['data']['slug']) && !empty($data['data']['slug'])) {
            $data['data']['slug'] = $this->ensureUniqueSlug($data['data']['slug'], $data['data']['id'] ?? null);
        }
        
        return $data;
    }

    private function createSlug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $slug = trim($slug, '-');
        
        return $this->ensureUniqueSlug($slug);
    }
    
    private function ensureUniqueSlug($slug, $excludeId = null)
    {
        $originalSlug = $slug;
        $counter = 1;
        
        $query = $this->where('slug', $slug);
        if ($excludeId) {
            $query->where('id !=', $excludeId);
        }
        
        while ($query->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = $this->where('slug', $slug);
            if ($excludeId) {
                $query->where('id !=', $excludeId);
            }
        }
        
        return $slug;
    }

    public function getFormWithFields($id)
    {
        $form = $this->find($id);
        if (!$form) {
            return null;
        }

        $formFieldModel = new FormFieldModel();
        $form['fields'] = $formFieldModel->where('form_id', $id)
                                       ->orderBy('field_order', 'ASC')
                                       ->findAll();

        return $form;
    }

    public function getFormBySlug($slug)
    {
        $form = $this->where('slug', $slug)
                    ->where('is_active', true)
                    ->first();
        
        if (!$form) {
            return null;
        }

        $formFieldModel = new FormFieldModel();
        $form['fields'] = $formFieldModel->where('form_id', $form['id'])
                                       ->orderBy('field_order', 'ASC')
                                       ->findAll();

        return $form;
    }
}
