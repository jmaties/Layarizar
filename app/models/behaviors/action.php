<?php
/**
 * Action Behavior
 *
 * PHP version 5
 *
 * @category Behavior

 */
class ActionBehavior extends ModelBehavior {

    function setup(&$model, $config = array()) {
        if (is_string($config)) {
            $config = array($config);
        }

        $this->settings[$model->alias] = $config;
    }

    function afterFind(&$model, $results = array(), $primary = false) {
        if ($primary && isset($results[0][$model->alias])) {
            foreach ($results AS $i => $result) {
                $customFields = array();
                if (isset($result['Action']) && count($result['Action']) > 0) {
                    $customFields = Set::combine($result, 'Action.{n}.label', 'Action.{n}.uri', 'Action.{n}.autoTriggerOnly');
                }
                $results[$i]['CustomFields'] = $customFields;
            }
        } elseif (isset($results[$model->alias])) {
            $customFields = array();
            if (isset($results['Action']) && count($results['Action']) > 0) {
                $customFields = Set::combine($results, 'Action.{n}.label', 'Action.{n}.uri', 'Action.{n}.autoTriggerOnly');
            }
            $results['CustomFields'] = $customFields;
        }

        return $results;
    }

    function prepareData(&$model, $data) {
        return $this->__prepareAction($data);
    }

    function __prepareAction($data) {
        if (isset($data['Action']) &&
            is_array($data['Action']) &&
            count($data['Action']) > 0 &&
            !Set::numeric(array_keys($data['Action']))) {
            $action = $data['Action'];
            $data['Action'] = array();
            $i = 0;
            foreach ($action AS $metaUuid => $metaArray) {
                $data['Action'][$i] = $metaArray;
                $i++;
            }
        }

        return $data;
    }

    function saveWithAction(&$model, $data, $options = array()) {
        $data = $this->__prepareAction($data);
        return $model->saveAll($data, $options);
    }

}
?>