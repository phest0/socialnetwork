<?php
include_once "PDO.php";

function GetOnePostFromId($id)
{
  global $PDO;
  $preparedRequest = $PDO->prepare("SELECT * FROM post WHERE id = :id");
  $preparedRequest->execute(
    array(
      "id" => $id
    )
  );
  return $preparedRequest->fetch();
}

function GetAllPosts()
{
  global $PDO;
  $response = $PDO->query(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "ORDER BY post.created_at DESC"
  );
  return $response->fetchAll();
}

function CreateNewPost($userId, $msg)
{
  global $PDO;
  if (isset($userId) && isset($msg)) {
    $preparedRequest = $PDO->prepare("INSERT INTO post(user_id, content) values (:userId, :msg)");
    $preparedRequest->execute(
      array(
        "userId" => $userId,
        "msg" => $msg
      )
    );
  }
}

function GetAllPostsFromUserId($userId)
{
  global $PDO;
  $preparedRequest = $PDO->prepare("SELECT * FROM post WHERE user_id = :userId ORDER BY created_at DESC");
  $preparedRequest->execute(
    array(
      "userId" => $userId
    )
  );

  return $preparedRequest->fetchAll();
}

function SearchInPosts($search)
{
  global $PDO;
  $preparedRequest = $PDO->prepare(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "WHERE content like :search or user.nickname like :search "
      . "ORDER BY post.created_at DESC"
  );

  $preparedRequest->execute(
    array(
      "search" => "%$search%"
    )
  );
  return $preparedRequest->fetchAll();
}
