<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\DB;

class IsCompositeUnique implements InvokableRule
{

    private string $tableName;
    private array $compositeColsKeyValue = [];
    private string $customMessage;
    private $rowId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $tableName, array $compositeColsKeyValue, $customMessage = null, $rowId = null)
    {
        $this->tableName = $tableName;
        $this->compositeColsKeyValue = $compositeColsKeyValue;
        $this->customMessage = $customMessage;
        $this->rowId = $rowId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param [type] $attribute
     * @param [type] $value
     * @param [type] $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $passess = true;

        if ($this->rowId) {
            $record = DB::table($this->tableName)->where($this->compositeColsKeyValue)->first();
            $passess = !$record || ($record && $record->id == $this->rowId);
        } else {
            $passess = !DB::table($this->tableName)->where($this->compositeColsKeyValue)->exists();
        }

        if (!$passess) {
            $fail($this->duplicateErrormessage());
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function duplicateErrormessage()
    {
        if ($this->customMessage != null || $this->customMessage != '') return $this->customMessage;

        $colNames = '';
        foreach ($this->compositeColsKeyValue as $col => $val) {
            $colNames .= $col . ', ';
        }
        $colNames = rtrim($colNames, ', ');

        return "The compination of " . $colNames . " must be unique.";
    }
}
