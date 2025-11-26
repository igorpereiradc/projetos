<?php

class TaskController {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function list() {
        $sql = $this->db->query("SELECT * FROM tasks ORDER BY id DESC");
        Response::json($sql->fetchAll(PDO::FETCH_ASSOC));
    }

    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['title']) || empty($data['title'])) {
            Response::json(['erro' => 'Título é obrigatório'], 400);
        }

        $stmt = $this->db->prepare("INSERT INTO tasks (title) VALUES (:title)");
        $stmt->execute(['title' => $data['title']]);

        Response::json(['mensagem' => 'Tarefa criada']);
    }

    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        $stmt = $this->db->prepare("UPDATE tasks SET title = :t, done = :d WHERE id = :id");
        $stmt->execute([
            't'  => $data['title'],
            'd'  => $data['done'],
            'id' => $id
        ]);

        Response::json(['mensagem' => 'Tarefa atualizada']);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);

        Response::json(['mensagem' => 'Tarefa removida']);
    }
}
