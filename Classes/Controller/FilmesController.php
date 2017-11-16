<?php
	namespace Locadora\Controller;
	use Locadora\Controller\Controller;
	use Locadora\Models\FilmesModel;
	use Slim\Http\UploadedFile;
	class FilmesController extends Controller{
		public function listarFilmes($request, $response, $args){
			$filme = new FilmesModel($this->container);
			$listafilmes = $filme->listarFilmes();
			return $this->view->render($response, 'filmes.twig', ['listaFilmes' => $listafilmes]);
		}
		public function editarFilme($request, $response, $args){
			$id = $args['id'];
			$filme = new FilmesModel($this->container);
			$editarfilme = $filme->editarFilme($id);
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$data = [
					'id' => filter_input(INPUT_POST, 'id'),
					'titulo' => filter_input(INPUT_POST, 'titulo'),
					'ano' => filter_input(INPUT_POST, 'ano'),
					'genero' => filter_input(INPUT_POST, 'genero'),
					'locado' => filter_input(INPUT_POST, 'locado')

				];
				if($data['locado'] == null){
					$data['locado'] = 0;
				}
				$filme = new FilmesModel($this->container);
				$filme->filmeEditado($data);
				return $response->withStatus(302)->withHeader('Location', '/home');
			}


			
			return $this->view->render($response ,'editarFilme.twig', ['editarFilme' => $editarfilme]);

		}
		public function novoFilme($request, $response, $args){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = [
					'titulo' => filter_input(INPUT_POST, 'titulo'),
					'locado' => 0,
					'ano' => filter_input(INPUT_POST, 'ano'),
					'genero' => filter_input(INPUT_POST, 'genero')

				];

				$filme = new FilmesModel($this->container);
				$novofilme = $filme->novoFilme($data);
				$id = $novofilme->id;


				$directory = $this->upload_directory;
				$uploadedFiles = $request->getUploadedFiles();
				$uploadedFile = $uploadedFiles['capa'];
				if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
	     	   		$filename = $this->moveUploadedFile($directory, $uploadedFile, $id);
	     	   		$filme->novoFilmeImagem($id, $filename);
	        	}

	    	}
    		return $this->view->render($response, 'novoFilme.twig');
		}
		public function apagarFilme($request, $response, $args){
			$id = $args['id'];
			$filme = new FilmesModel($this->container);
			$apagarFilme = $filme->apagarFilme($id);
			if($apagarFilme == 0){
				$response->write('<script>alert("O filme não foi apagado tente novamente");</script>');
				
			}else{
				$response->write('<script>alert("Apagado com sucesso");</script>');
				return $response->withStatus(302)->withHeader('Location', '/home');
			}
			
		}
		function moveUploadedFile($directory, UploadedFile $uploadedFile, $id){

				if(!is_dir($this->upload_directory)){
					mkdir($this->upload_directory);
				} 
			    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
			    $basename = $id; // see http://php.net/manual/en/function.random-bytes.php
			    $filename = sprintf('%s.%0.8s', $basename, $extension);

			    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

			    return $filename;
			    
			}



	}