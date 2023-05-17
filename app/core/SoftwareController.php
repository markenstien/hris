<?php   

    class SoftwareController extends Controller
    {
        final public function view($view , $data = [])
		{
			$GLOBALS['data'] = $data;
			
			$view = convertDotToDS($view);

			extract($data);

			$pathView = APP_EXTENSIONS_PATH.DS.url(0).DS.'views'.DS.$view.'.php';

            if(file_exists($pathView))
            {
                require_once $pathView;
            }else{
                die("View {$view} does not exists");
            }
		}

		final public function model($model)
		{

			$model = ucfirst($model);

			$pathModel = APP_EXTENSIONS_PATH.DS.url(0).DS.'models'.DS.$model.'.php';

			if(file_exists($pathModel)){

				require_once $pathModel;

				return new $model;
			}
			else{

				die($model . 'MODEL NOT FOUND');
			}
		}

		final public function loadModels($models)
		{
			foreach($models as $key => $row) 
			{
				$model = ucfirst($row);

				$pathModel = APP_EXTENSIONS_PATH.DS.url(0).DS.'models'.DS.$model.'.php';

				if(file_exists($pathModel)){

					require_once $pathModel;

					$this->$key = new $model;
				}
				else{

					die($model . 'MODEL NOT FOUND');
				}
			}
		}
    }