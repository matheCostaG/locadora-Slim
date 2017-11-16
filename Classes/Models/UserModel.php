<?php
	namespace Locadora\Models;

	use Locadora\Models\Model;

	class UserModel extends Model{
		public function logar($login, $senha){
			$table = $this->db->table('usuarios');
			$user = $table->where(['login' => $login, 'senha' => $senha])->get();
			return $user;
		}
		public function novoUser($data){
			$table = $this->db->table('usuarios');
			$user = $table->insert($data);
			return $user;
		}
		public function listarUsuarios(){
			$table = $this->db->table('usuarios');
			$user = $table->get();
			return $user;
		}
		public function apagarUsuario($id){
			$table = $this->db->table('usuarios');
			$user = $table->where('id', $id)->delete();
			return $user;
		}
	}