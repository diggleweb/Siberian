<?php

/**
 * Class Customer_Model_Customer_Push
 */
class Customer_Model_Customer_Push
{
    /**
     * @param Customer_Model_Customer $customer
     * @param Application_Model_Application $application
     * @param string $deviceUid
     */
    public static function registerForIndividualPush ($customer, $application, $deviceUid)
    {
        if (!empty($deviceUid)) {
            $appId = $application->getId();

            if (strlen($deviceUid) === 36) {
                $device = (new Push_Model_Iphone_Device())
                    ->find(
                        [
                            'device_uid' => $deviceUid,
                            'app_id' => $appId,
                        ]
                    );
            } else {
                $device = (new Push_Model_Android_Device())
                    ->find(
                        [
                            'device_uid' => $deviceUid,
                            'app_id' => $appId,
                        ]
                    );
            }

            if ($device && $device->getId()) {
                $device
                    ->setCustomerId($customer->getId())
                    ->save();
            }
        }
    }

}
