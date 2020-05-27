<?php
include_once "PDO.php";

function GetOneCommentFromId($id)
{
  global $PDO;
  $preparedRequest = $PDO->prepare("SELECT * FROM comment WHERE id = :id");
  $preparedRequest->execute(
    array(
      "id" => $id
    )
  );
  return $preparedRequest->fetch();
}

function GetAllComments()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM comment ORDER BY created_at ASC");
  return $response->fetchAll();
}

function GetAllCommentsFromUserId($userId)
{
  global $PDO;
  $preparedRequest = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.user_id = :userId "
      . "ORDER BY comment.created_at ASC"
  );
  $preparedRequest->execute(
    array(
      "userId" => $userId
    )
  );
  return $preparedRequest->fetchAll();
}

function GetAllCommentsFromPostId($postId)
{
  global $PDO;
  $preparedRequest = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.post_id = :postId "
      . "ORDER BY comment.created_at ASC"
  );

  $preparedRequest->execute(
    array(
      "postId" => $postId
    )
  );
  return $preparedRequest->fetchAll();
}

function CreateNewComment($userId, $postId, $content)
{
  global $PDO;
  $preparedRequest = $PDO->prepare("INSERT INTO comment(user_id, post_id, content) values (:userId, :postId, :comment)");
  $preparedRequest->execute(
    array(
      "userId" => $userId,
      "postId" => $postId,
      "comment" => $content
    )
  );
}
