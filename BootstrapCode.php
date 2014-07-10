<?php
/**
 * BootstrapCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.gii
 */

Yii::import('gii.generators.crud.CrudCode');

class BootstrapCode extends CrudCode
{
    public function generateControlGroup($modelClass, $column)
    {
        if ($column->type === 'boolean') {
            return "TbHtml::activeCheckBoxControlGroup(\$model,'{$column->name}')";
        } else {
            if (stripos($column->dbType, 'text') !== false) {
                return "TbHtml::activeTextAreaControlGroup(\$model,'{$column->name}',array('rows'=>6,'span'=>8))";
            } else {
                if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                    $inputField = 'activePasswordControlGroup';
                } else {
                    $inputField = 'activeTextFieldControlGroup';
                }

                if ($column->type !== 'string' || $column->size === null) {
                    return "TbHtml::{$inputField}(\$model,'{$column->name}')";
                } else {
                    if (($size = $maxLength = $column->size) > 60) {
                        $size = 60;
                    }
                    return "TbHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
                }
            }
        }
    }

    public function generateActiveControlGroup($modelClass, $column)
    {
		if ($column->isForeignKey) {
			$relation = $this->findRelation($modelClass, $column);
			$relatedModelClass = $relation[3];
			return "\$form->dropDownListControlGroup(\$model, '{$column->name}', GxHtml::listDataEx({$relatedModelClass}::model()->findAllAttributes(null, true)))";
		}

		if (strtoupper($column->dbType) == 'TINYINT(1)'
			|| strtoupper($column->dbType) == 'BIT'
			|| strtoupper($column->dbType) == 'BOOL'
			|| strtoupper($column->dbType) == 'BOOLEAN') {
            return "\$form->checkBoxControlGroup(\$model,'{$column->name}')";
        } else if (strtoupper($column->dbType) == 'DATE') {
			return "\$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => \$model,
			'attribute' => '{$column->name}',
			'value' => \$model->{$column->name},
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));\n";
			// todo удалять echo при поле date
		} else {
            if (stripos($column->dbType, 'text') !== false) {
                return "\$form->textAreaControlGroup(\$model,'{$column->name}',array('rows'=>6,'span'=>8))";
            } else {
                if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                    $inputField = 'passwordFieldControlGroup';
                } else {
                    $inputField = 'textFieldControlGroup';
                }

                if ($column->type !== 'string' || $column->size === null) {
                    return "\$form->{$inputField}(\$model,'{$column->name}',array('span'=>5))";
                } else {
                    return "\$form->{$inputField}(\$model,'{$column->name}',array('span'=>5,'maxlength'=>$column->size))";
                }
            }
        }
    }


	/**
	 * Finds the relation of the specified column.
	 * Note: There's a similar method in the class GxActiveRecord.
	 * @param string $modelClass The model class name.
	 * @param CDbColumnSchema $column The column.
	 * @return array The relation. The array will have 3 values:
	 * 0: the relation name,
	 * 1: the relation type (will always be GxActiveRecord::BELONGS_TO),
	 * 2: the foreign key (will always be the specified column),
	 * 3: the related active record class name.
	 * Or null if no matching relation was found.
	 */
	public function findRelation($modelClass, $column) {
		if (!$column->isForeignKey)
			return null;
		$relations = GxActiveRecord::model($modelClass)->relations();
		// Find the relation for this attribute.
		foreach ($relations as $relationName => $relation) {
			// For attributes on this model, relation must be BELONGS_TO.
			if ($relation[0] == GxActiveRecord::BELONGS_TO && $relation[2] == $column->name) {
				return array(
					$relationName, // the relation name
					$relation[0], // the relation type
					$relation[2], // the foreign key
					$relation[1] // the related active record class name
				);
			}
		}
		// None found.
		return null;
	}
}
