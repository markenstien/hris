<?php 
    namespace Services;

    class CommonMetaService
    {
        const CATALOG_LIKE = 'CATALOG_LIKE';
        const COMMENT_LIKE = 'COMMENT_LIKE';
        const CATALOG_READ = 'CATALOG_READ';
        const CATALOG_VIEW = 'CATALOG_VIEW';

        public static $model = null;
        public static $message = '';
        
        public static function addRecord($parentId, $metaKey, $metaValue, $userId = null) {
            $retVal = '';
            if(is_null(self::$model)) {
                self::$model = model('CommonMetaModel');
            }

            $userId = is_null($userId) ? whoIs('id') : $userId;

            switch($metaKey) {
                case self::COMMENT_LIKE;
                case self::CATALOG_LIKE:
                    $instance = self::$model->single([
                        'parent_id' => $parentId,
                        'meta_key' => $metaKey,
                        'user_id' => $userId
                    ]);

                    if($instance) {
                        self::$model->delete($instance->id);
                        self::$message = "Un liked";
                    }else{
                        self::storeData($parentId, $metaKey, $metaValue, $userId);
                        self::$message = "liked";
                    }
                break;

                case self::CATALOG_READ:
                    $instance = self::$model->single([
                        'parent_id' => $parentId,
                        'meta_key' => $metaKey,
                        'user_id' => $userId
                    ]);
                    if($instance) {
                        /**
                         * view will only increase if the last view of user is after 24 hours
                         */
                        if(timeDifference($instance->created_at, nowMilitary()) >= 24) {
                            self::storeData($parentId, $metaKey, $metaValue, $userId);
                        }
                    } else {
                        self::storeData($parentId, $metaKey, $metaValue, $userId);
                    }
                break;

                case self::CATALOG_VIEW:
                    $instance = self::$model->single([
                        'parent_id' => $parentId,
                        'meta_key' => $metaKey,
                        'user_id' => $userId
                    ],'*', 'id desc');
                    if($instance) {
                        /**
                         * view will only increase if the last view of user is after 10 hours
                         */
                        if(timeDifference($instance->created_at, nowMilitary()) >= 1) {
                            self::storeData($parentId, $metaKey, $metaValue, $userId);
                        }
                    } else {
                        self::storeData($parentId, $metaKey, $metaValue, $userId);
                    }
                break;
            }
        }

        public static function storeData($parentId, $metaKey, $metaValue, $userId = null) {
            self::$model->store([
                'parent_id' => $parentId,
                'meta_key' => $metaKey,
                'meta_value' => $metaValue,
                'user_id'   => $userId,
                'created_at' => nowMilitary()
            ]);
        }
    }