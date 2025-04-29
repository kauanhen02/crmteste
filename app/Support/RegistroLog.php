<?php

namespace App\Support;

use App\LogInstituicao;
use App\Models\Log;

trait RegistroLog {

    public function logs() {
        return $this->morphMany(Log::class, "registro");
    }

    public function criarLog($usuario, $descricao, $dados = null) {
        return $this->logs()->create([
            'usuario_id' => $usuario->id,
            'usuario_type' => get_class($usuario),
            'descricao' => $descricao,
            'dados' => $dados,
        ]);
    }

    public function criarLogCadastro($usuario) {
        return $this->criarLog($usuario, 'Cadastro', $this->getAttributes());
    }

    public function criarLogEdicao($usuario) {
        return $this->criarLog($usuario, 'Edição', $this->getChanges());
    }

    public function criarLogExclusao($usuario) {
        return $this->criarLog($usuario, 'Exclusão', $this->getChanges());
    }

}
