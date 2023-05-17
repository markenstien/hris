<?php
    namespace Services;

    class StockService {
        const SALES = 'SALES';
        const PURCHASE_ORDER = 'PURCHASE_ORDER';

        const ENTRY_ORIGIN = 'PURCHASE_ITEM';
        const ENTRY_ORIGIN_DEFECTIVE_ITEM = 'DEFECTIVE_ITEM';

        const BORROW = 'BORROW';
        const RETURN_ITEM = 'RETURN_ITEM';
        const ENTRY_DEDUCT = 'DEDUCT';
        const ENTRY_ADD = 'ADD';

        const HIGHEST_QUANTITY = 'HIGHEST_BY_QUANTITY';
        const LOWEST_QUANTITY = 'LOWEST_BY_QUANTITY';
        
        const HIGHEST_BY_MAX_QUANTITY = 'HIGHEST_BY_MAX_QUANTITY';
        const LOWEST_BY_MAX_QUANTITY = 'LOWEST_BY_MAX_QUANTITY';

        private $_stockModel = null;
        public function loadStockModel() {
            $this->_stockModel = model('StockModel');
        }

        public function getHighestStock($type, $param) {
            return $this->_stockModel->getHighestStock($type, $param);
        }
    }