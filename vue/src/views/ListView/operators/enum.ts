import { modifiers } from './_modifiers'

export default {
    equal: {
        label: 'LBL_ESLIST_EQUAL',
        inputs: [{ type: 'select', label: 'LBL_ESLIST_VALUE', modifiers: [modifiers.toLower] }],
        filters: [{ op: 'term', value: '{0}' }],
    },
    not_equal: {
        label: 'LBL_ESLIST_NOT_EQUAL',
        not: true,
        inputs: [{ type: 'select', label: 'LBL_ESLIST_VALUE', modifiers: [modifiers.toLower] }],
        filters: [{ op: 'term', value: '{0}' }],
    },
    contain: {
        label: 'LBL_ESLIST_CONTAIN',
        inputs: [{ type: 'multiselect', label: 'LBL_ESLIST_VALUES', modifiers: [modifiers.toLower] }],
        filters: [{ op: 'terms', value: '{0}' }],
    },
    not_contain: {
        label: 'LBL_ESLIST_NOT_CONTAIN',
        not: true,
        inputs: [{ type: 'multiselect', label: 'LBL_ESLIST_VALUES', modifiers: [modifiers.toLower] }],
        filters: [{ op: 'terms', value: '{0}' }],
    },
}
