<?php
namespace Api\V8\JsonApi\Helper;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Response\AttributeResponse;

class AttributeObjectHelper
{
    /**
     * @var BeanManager
     */
    protected $beanManager;

    /**
     * @param BeanManager $beanManager
     */
    public function __construct(BeanManager $beanManager)
    {
        $this->beanManager = $beanManager;
    }

    /**
     * @param \SugarBean $bean
     * @param array|null $fields
     *
     * @return AttributeResponse
     */
    public function getAttributes(\SugarBean $bean, $fields = null)
    {
        $bean->fixUpFormatting();

        $current_time_zone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $allowedField = [];

        $fieldsToParse = $fields;
        if (empty($fields)) {
            $fieldsToParse =  array_keys($bean->field_defs);
        }

        foreach ($fieldsToParse ?? [] as $index => $field) {
            $isSensitive = isTrue($bean->field_defs[$field]['sensitive'] ?? false);
            $notApiVisible = isFalse($bean->field_defs[$field]['api-visible'] ?? true);

            if ($isSensitive || $notApiVisible){
                continue;
            }

            $allowedField[$index] = $field;
        }

        // using the ISO 8601 format for dates
        $attributes = array_map(function ($value) {
            return is_string($value)
                ? (\DateTime::createFromFormat('Y-m-d H:i:s', $value)
                    ? date(\DateTime::ATOM, strtotime($value))
                    : html_entity_decode(htmlspecialchars_decode($value), ENT_QUOTES))
                : $value;
        }, $bean->toArray());

        date_default_timezone_set($current_time_zone);
        if ($allowedField !== null) {
            $attributes = array_intersect_key($attributes, array_flip($allowedField));
        }
        // MintHCM #87119 start
        $attributes['acl_access'] = [
            'edit' => $bean->ACLAccess('edit'),
            'view' => $bean->ACLAccess('view'),
            'delete' => $bean->ACLAccess('delete'),
        ];
        // MintHCM #87119 end

        unset($attributes['id']);

        return new AttributeResponse($attributes);
    }
}
