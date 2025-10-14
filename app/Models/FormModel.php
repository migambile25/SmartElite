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
        'is_primary',
        'success_message',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_flag',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

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
        $form['fields'] = $formFieldModel->getFieldsByFormId($id);

        return $form;
    }

    public function getFormBySlug($slug)
    {
        $form = $this->where('slug', $slug)
                    ->where('is_active', true)
                    ->where('deleted_flag', false)
                    ->first();
        
        if (!$form) {
            return null;
        }

        $formFieldModel = new FormFieldModel();
        $form['fields'] = $formFieldModel->getFieldsByFormId($form['id']);

        return $form;
    }

    /**
     * Soft delete a form by setting deleted_flag to true and deleted_at timestamp
     */
    public function softDelete($id)
    {
        return $this->update($id, [
            'deleted_flag' => true,
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Restore a soft-deleted form by setting deleted_flag to false and clearing deleted_at
     */
    public function restore($id)
    {
        return $this->update($id, [
            'deleted_flag' => false,
            'deleted_at' => null
        ]);
    }

    /**
     * Find form including soft-deleted ones
     */
    public function findWithDeleted($id)
    {
        return parent::find($id);
    }

    /**
     * Get active (non-deleted) forms only
     */
    public function findActive($id = null)
    {
        if ($id === null) {
            return $this->where('deleted_flag', false)->findAll();
        }
        return $this->where('deleted_flag', false)->where('id', $id)->first();
    }

    /**
     * Get all active (non-deleted) forms
     */
    public function findAllActive(?int $limit = null, int $offset = 0)
    {
        return $this->where('deleted_flag', false)->findAll($limit, $offset);
    }

    /**
     * Get the primary form (the one marked as primary)
     */
    public function getPrimaryForm()
    {
        $primaryForm = $this->where('deleted_flag', false)
                           ->where('is_active', true)
                           ->where('is_primary', true)
                           ->first();
        
        // If no primary form is set, fall back to the first active form
        if (!$primaryForm) {
            $primaryForm = $this->where('deleted_flag', false)
                               ->where('is_active', true)
                               ->orderBy('created_at', 'ASC')
                               ->first();
        }
        
        return $primaryForm;
    }
}
