<?php

namespace App\Models;

use CodeIgniter\Model;

class FormFieldModel extends Model
{
    protected $table = 'form_fields';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'form_id',
        'field_name',
        'field_label',
        'field_type',
        'field_options',
        'is_required',
        'field_order',
        'validation_rules',
        'created_at',
        'updated_at',
        'deleted_flag'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'form_id' => 'required|integer',
        'field_name' => 'permit_empty|min_length[2]|max_length[255]|alpha_dash',
        'field_label' => 'required|min_length[2]|max_length[255]',
        'field_type' => 'required|in_list[text,email,tel,number,date,textarea,select,radio,checkbox,file]',
        'field_options' => 'permit_empty',
        'is_required' => 'permit_empty',
        'field_order' => 'permit_empty|integer',
        'validation_rules' => 'permit_empty'
    ];

    protected $validationMessages = [
        'form_id' => [
            'required' => 'Form ID is required',
            'integer' => 'Form ID must be a valid integer'
        ],
        'field_name' => [
            'min_length' => 'Field name must be at least 2 characters long',
            'max_length' => 'Field name cannot exceed 255 characters',
            'alpha_dash' => 'Field name can only contain letters, numbers, dashes and underscores'
        ],
        'field_label' => [
            'required' => 'Field label is required',
            'min_length' => 'Field label must be at least 2 characters long',
            'max_length' => 'Field label cannot exceed 255 characters'
        ],
        'field_type' => [
            'required' => 'Field type is required',
            'in_list' => 'Field type must be one of: text, email, tel, number, date, textarea, select, radio, checkbox, file'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['setFieldOrder', 'processFieldOptions', 'generateFieldName'];
    protected $beforeUpdate = ['processFieldOptions', 'generateFieldName'];

    protected function setFieldOrder(array $data)
    {
        if (!isset($data['data']['field_order']) || $data['data']['field_order'] === 0) {
            $maxOrder = $this->where('form_id', $data['data']['form_id'])
                           ->selectMax('field_order')
                           ->first();
            $data['data']['field_order'] = ($maxOrder['field_order'] ?? 0) + 1;
        }
        return $data;
    }

    protected function processFieldOptions(array $data)
    {
        if (isset($data['data']['field_options'])) {
            if (is_array($data['data']['field_options'])) {
                $data['data']['field_options'] = json_encode($data['data']['field_options']);
            } elseif (is_string($data['data']['field_options']) && !empty(trim($data['data']['field_options']))) {
                // Handle textarea input - split by newlines and create array
                $options = array_filter(array_map('trim', explode("\n", $data['data']['field_options'])));
                $data['data']['field_options'] = !empty($options) ? json_encode($options) : null;
            } else {
                // Empty or null value
                $data['data']['field_options'] = null;
            }
        }
        return $data;
    }

    protected function generateFieldName(array $data)
    {
        // Debug: Log the callback execution
        log_message('debug', 'generateFieldName callback called with data: ' . json_encode($data));
        
        // If field_name is empty or not provided, generate it from field_label
        if (empty($data['data']['field_name']) && !empty($data['data']['field_label'])) {
            $excludeId = $data['data']['id'] ?? null;
            $generatedName = $this->createFieldName($data['data']['field_label'], $data['data']['form_id'], $excludeId);
            $data['data']['field_name'] = $generatedName;
            log_message('debug', 'Generated field name: ' . $generatedName);
        }
        return $data;
    }

    private function createFieldName($label, $formId, $excludeId = null)
    {
        // Convert label to field name: "First Name" -> "first_name"
        $fieldName = strtolower(trim(preg_replace('/[^A-Za-z0-9\s]+/', '', $label)));
        $fieldName = preg_replace('/\s+/', '_', $fieldName);
        $fieldName = trim($fieldName, '_');
        
        // Ensure uniqueness within the form
        $originalFieldName = $fieldName;
        $counter = 1;
        
        $query = $this->where('form_id', $formId)->where('field_name', $fieldName);
        if ($excludeId) {
            $query->where('id !=', $excludeId);
        }
        
        while ($query->first()) {
            $fieldName = $originalFieldName . '_' . $counter;
            $counter++;
            
            $query = $this->where('form_id', $formId)->where('field_name', $fieldName);
            if ($excludeId) {
                $query->where('id !=', $excludeId);
            }
        }
        
        return $fieldName;
    }

    public function getFieldsByFormId($formId)
    {
        return $this->where('form_id', $formId)
                   ->orderBy('field_order', 'ASC')
                   ->findAll();
    }

    public function reorderFields($formId, $fieldOrders)
    {
        foreach ($fieldOrders as $fieldId => $order) {
            $this->update($fieldId, ['field_order' => $order]);
        }
        return true;
    }

    public function getFieldOptions($fieldId)
    {
        $field = $this->find($fieldId);
        if ($field && $field['field_options']) {
            return json_decode($field['field_options'], true);
        }
        return [];
    }

    public function setFieldOptions($fieldId, $options)
    {
        return $this->update($fieldId, ['field_options' => json_encode($options)]);
    }

    /**
     * Soft delete a field by setting deleted_flag to true and deleted_at timestamp
     */
    public function softDelete($id)
    {
        return $this->update($id, [
            'deleted_flag' => true,
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Restore a soft-deleted field by setting deleted_flag to false and clearing deleted_at
     */
    public function restore($id)
    {
        return $this->update($id, [
            'deleted_flag' => false,
            'deleted_at' => null
        ]);
    }

    /**
     * Find field including soft-deleted ones
     */
    public function findWithDeleted($id)
    {
        return parent::find($id);
    }

    /**
     * Get all fields including soft-deleted ones
     */
    public function findAllWithDeleted($formId = null)
    {
        $query = $this;
        if ($formId) {
            $query = $query->where('form_id', $formId);
        }
        return $query->orderBy('field_order', 'ASC')->findAll();
    }

    /**
     * Get active (non-deleted) fields only
     */
    public function findActive($id = null)
    {
        if ($id === null) {
            return $this->where('deleted_flag', false)->findAll();
        }
        return $this->where('deleted_flag', false)->where('id', $id)->first();
    }

    /**
     * Get all active (non-deleted) fields
     */
    public function findAllActive(?int $limit = null, int $offset = 0)
    {
        return $this->where('deleted_flag', false)->findAll($limit, $offset);
    }
}
