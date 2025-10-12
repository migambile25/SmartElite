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
        'form_id' => 'required|integer',
        'field_name' => 'required|min_length[2]|max_length[255]|alpha_dash',
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
            'required' => 'Field name is required',
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
    protected $beforeInsert = ['setFieldOrder', 'processFieldOptions'];
    protected $beforeUpdate = ['processFieldOptions'];

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
        if (isset($data['data']['field_options']) && is_array($data['data']['field_options'])) {
            $data['data']['field_options'] = json_encode($data['data']['field_options']);
        }
        return $data;
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
}
