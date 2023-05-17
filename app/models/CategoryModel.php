<?php

	class CategoryModel extends Model
	{
		public $table = 'categories';

		protected $_fillables = [
			'category',
			'cat_key',
			'description',
			'created_by'
		];

		public function getAll( $params = [] )
		{
			return parent::getAssoc($params['order'] ?? 'category' , $params['where'] ?? null);
		}

		public function save( $category_data , $id = null)
		{
			$fillable_datas = $this->getFillablesOnly($category_data);

			$validate = $this->validate($fillable_datas);

			if(!$validate) return false;

			if( !is_null($id) )
			{
				return parent::update( $fillable_datas , $id);
			}else
			{

				_notify_operations("Category {$category_data['category']} has been created");

				$this->addMessage("Category Created!");
				return parent::store( $fillable_datas );
			}
		}

		public function validate($fillable_datas)
		{
			//check if category exists with same key

			if( parent::single(['category' => $fillable_datas['category'] , 'cat_key' => $fillable_datas['cat_key']]) )
			{
				$this->addError("Category and Category Key Combination already exists");
				return false;
			}

			return true;
		}
	}