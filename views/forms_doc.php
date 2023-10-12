<?php
include_once "basic_doc.php";

abstract class FormsDoc extends BasicDoc {

    protected function showFormStart($hasRequiredFields) {
        echo'
        <form method="post" action="index.php">';
            if ($hasRequiredFields) {
                echo'
                <p><span class="error"><strong>* Vereist veld</strong></span></p>';
            }
            echo'
            <ul class="flex-outer">';
    }

    protected function showFormField($fieldName, $label, $type, $options = NULL, $optional = false) {
        echo '
        <li>';
            if ($type != 'radio') {
            echo '<label for="' . $fieldName . '">' . $label . '</label>';
            }

    
    
        switch($type) {
           
            case 'select':
                echo '
                <select name="' . $fieldName . '" id="' . $fieldName . '">
                    <option disabled selected value> -- maak een keuze -- </option>';
                    if (is_array($options)) {
                        foreach ($options as $key => $label) {
                            echo '
                            <option value="' . $key . '"' . ($this->model->{$fieldName} === $key ? "selected" : "") . '>' . $label . '</option>';
                        }
                    }
                echo '
                </select>
                ';
                break;
    
            case 'radio':
                echo '
                <legend>' . $label . '</legend>';
                if (is_array($options)) {
                    foreach ($options as $key => $label) {
                        $optionId = $fieldName . '_' . $key;
                        echo '
                        <li>
                            <input type="' . $type . '" id="' . $optionId . '" name="' . $fieldName . '" value="' . $key . '"' . ($this->model->{$fieldName} === $key ? "checked" : "") . '>
                            <label for="' . $key . '">' . $label . '</label>
                        </li>';
                        }
                }
                break;
    
            case 'textarea':
                echo '
                <textarea id="' . $fieldName . '" name="' . $fieldName . '"';
                if (is_array($options)) {
                    foreach ($options as $key => $value) {
                        echo ' ' . $key . '="' . $value . '"';
                    }
                }
                echo '
                >' . $this->model->{$fieldName} . '</textarea>';
                break;

            default:
                echo '
                <input type="' . $type . '" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $this->model->{$fieldName} . '">';
                break;
        
        }
    
        if (!$optional && isset($this->model->{$fieldName . 'Err'}) && !empty($this->model->{$fieldName . 'Err'})) {
            echo '<span class="error">* ' . $this->model->{$fieldName . 'Err'} . '</span>';
        }

    
        if (!$optional) {
            $extraErrors = [
                'email' => ['emailknownErr', 'emailunknownErr'],
                'repeatpass' => ['passcheckErr'],
                'pass' => ['wrongpassErr', 'oldvsnewpassErr'],
            ];
        
            if (isset($extraErrors[$fieldName])) {
                foreach ($extraErrors[$fieldName] as $errorKey) {
                    if (!empty($this->model->{$errorKey})) {
                        echo '<span class="error">* ' . $this->model->{$errorKey} . '</span>';
                    }
                }
            }
        }
    
        echo '    
        </li>';
    }
    
    protected function showFormEnd($page, $submitButtonText) {
        echo '
            <li>
                <button type="submit" name="page" value="' . $page . '">' . $submitButtonText . '</button>
            </li>
        </ul>
    </form>';
    }
    
}

?>