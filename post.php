<?php


if($_GET){
    $data = listAll();
    echo json_encode($data);exit;
}

if($_POST){
    $aluno = $_POST['aluno'];
    $turma = $_POST['turma'];
    $materia = $_POST['materia'];
    $nota = $_POST['nota'];

    if($aluno == ""){
        echo json_encode(["status"=>false,"msg"=>"Preencha o campo Aluno"]);exit;
    }
    
    if($turma == ""){
        echo json_encode(["status"=>false,"msg"=>"Preencha o campo Turma"]);exit;
    }
    
    if($materia == ""){
        echo json_encode(["status"=>false,"msg"=>"Preencha o campo Materia"]);exit;
    }
    
    if($nota == ""){
        echo json_encode(["status"=>false,"msg"=>"Preencha o campo Nota"]);exit;
    }

    $id = save($_POST);
    
    if($id){
        $data = find($id);
        echo json_encode(["status"=>true,"msg"=>"Success! Id: {$id}","notas"=>$data]);exit;
    }else{
        echo json_encode(["status"=>false,"msg"=>"Error Db!"]);exit;
    }

}

function conn(){
    $conn = new \PDO("mysql:host=localhost;dbname=boletim","root","root");
    return $conn;
}

function save($data){
    $db = conn();
    $query ="Insert into `notas` (`aluno`,`turma`,`materia`,`nota`) VALUES (:aluno,:turma,:materia,:nota)";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':aluno',$data['aluno']);
    $stmt->bindValue(':turma',$data['turma']);
    $stmt->bindValue(':materia',$data['materia']);
    $stmt->bindValue(':nota',$data['nota']);
    $stmt->execute();
    return $db->lastInsertId();
}

function listAll(){
    $db = conn();
    $query ="Select * from `notas` order by id DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}
function find($id){
    $db = conn();
    $query ="Select * from `notas` where id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':id',$id);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

