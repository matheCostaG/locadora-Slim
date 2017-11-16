<?php
	namespace Locadora\Models;

	use Locadora\Models\Model;

	class FilmesModel extends Model{
		public function listarFilmes(){
			$table = $this->db->table('filme');
			$filmes = $table->get();
			return $filmes;
		}
		public function editarFilme($id){
			$table = $this->db->table('filme');
			$filme = $table->where('id', $id)->get();
			return $filme;
		}
		public function novoFilme($data){
			$table = $this->db->table('filme');
			$table->insert($data);
			$filme = $table->get()->last();
			return $filme;
		}
		public function novoFilmeImagem($id ,$filmename){
			$table = $this->db->table('filme');
			$table->where('id' , $id)->update(['img_filme' => $filmename]);
		}
		public function apagarFilme($id){
			$table = $this->db->table('filme');
			$filme = $table->where('id' , $id)->delete();
			return $filme;
		}
		public function filmeEditado($data){
			$table = $this->db->table('filme');
			$filme = $table->where('id' ,$data['id'])->update(['titulo' => $data['titulo'], 'locado' => $data['locado'], 'ano' => $data['ano'], 'genero' => $data['genero']]);
		}
	}