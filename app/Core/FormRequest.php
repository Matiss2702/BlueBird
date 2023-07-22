<?php

namespace App\Core;

use App\Requests\Abstract\AFormRequest;
use App\Models\Menu;
use App\Core\QueryBuilder;

class FormRequest extends AFormRequest
{
    private array $rules;
    private array $errors;

    public function __construct(array $rules)
    {
        $this->rules  = $rules;
        $this->errors = [];

        parent::__construct();
    }

    public function validate(): ?\ArrayObject
    {
        $data = $this->getRequest()->getPost();

        foreach ($this->rules as $field => $rules) {
            $fieldValue = isset($data[$field]) ? $data[$field] : null;
            $fieldErrors = $this->validateField($field, $fieldValue, $rules);

            if (!empty($fieldErrors)) {
                $this->errors[$field] = $fieldErrors;
            }
        }

        if (!empty($this->errors)) {
            $this->setOldInput($data);
            return null;
        }

        return $data;
    }

    private function validateField($field, $value, $rules): array
    {
        $fieldErrors = [];

        foreach (explode('|', $rules) as $rule) {
            $ruleParts = explode(':', $rule);
            $ruleName = $ruleParts[0];
            $ruleParams = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];

            switch ($ruleName) {
                case 'required':                    $cleanedValue = strip_tags(html_entity_decode(trim($value)));
                    if (empty($cleanedValue)) {
                        $fieldErrors[] = 'Le champ ' . $field . ' est requis.';
                    }
                    break;

                case 'string':
                    if (!is_string($value)) {
                        $fieldErrors[] = 'Le champ ' . $field . ' doit être une chaîne de caractères.';
                    }
                    break;

                case 'numeric':
                    if (!is_numeric($value)) {
                        $fieldErrors[] = 'Le champ ' . $field . ' doit être numérique.';
                    }
                    break;

                case 'date':
                    if (strtotime($value) === false) {
                        $fieldErrors[] = 'Le champ ' . $field . ' doit être une date valide.';
                    }
                    break;

                case 'time':
                    if (strtotime($value) === false) {
                        $fieldErrors[] = 'Le champ ' . $field . ' doit être un temps valide.';
                    }
                    break;

                case 'integer':
                    if (!filter_var($value, FILTER_VALIDATE_INT)) {
                        $fieldErrors[] = 'Le champ ' . $field . ' doit être un entier.';
                    }
                    break;

                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fieldErrors[] = 'Le champ ' . $field . ' doit être une adresse email valide.';
                    }
                    break;

                case 'max':
                    $maxLength = intval($ruleParams[0]);
                    if (strlen($value) > $maxLength) {
                        $fieldErrors[] = 'Le champ ' . $field . ' ne doit pas dépasser ' . $maxLength . ' caractères.';
                    }
                    break;

                case 'min':
                    $minLength = intval($ruleParams[0]);
                    if (strlen($value) < $minLength) {
                        $fieldErrors[] = 'Le champ ' . $field . ' doit contenir au moins ' . $minLength . ' caractères.';
                    }
                    break;

                case 'in':
                    $allowedValues = array_slice($ruleParams, 0);
                    if (!in_array($value, $allowedValues)) {
                        $fieldErrors[] = 'La valeur du champ ' . $field . ' n\'est pas valide.';
                    }
                    break;

                case 'same':
                    $otherField = $ruleParams[0];
                    if ($value !== $this->getRequest()->getPost($otherField)) {
                        $fieldErrors[] = 'Le champ ' . $field . ' ne correspond pas au champ ' . $otherField . '.';
                    }
                    break;

                case 'unique':
                    $table = $ruleParams[0];
                    $value = $this->getRequest()->getPost($field);
                    if (!empty($value)) {
                        if (!$this->isValueUnique($table, $field, $value)) {
                            $fieldErrors[] = 'La valeur du champ ' . $field . ' est déjà utilisée par un autre menu !';
                        }
                    }
                    break;

                default:
                    $fieldErrors[] = 'Une erreur est survenue';
                    break;
            }
        }

        return $fieldErrors;
    }

    private function isValueUnique($table, $field, $value)
    {
        $uniquePk = $this->uniquePk ?? 0;
        $isUnique = QueryBuilder::table($table)
            ->select()
            ->where($field, $value)
            ->andWhere('id', '!=', $uniquePk)
            ->notExists();
        return $isUnique;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError($field, $error): void
    {
        $this->errors[$field] = [$error];
    }

    public function getOld()
    {
        return isset($_SESSION['old_input']) ? $_SESSION['old_input'] : [];
    }

    public function setOldInput($data): void
    {
        $_SESSION['old_input'] = $data;
    }

}