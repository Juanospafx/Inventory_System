<?php

class ProjectService
{
  public static function all()
  {
    return find_all('projects');
  }

  public static function find($id)
  {
    return find_by_id('projects', (int) $id);
  }

  public static function create($name)
  {
    global $db;
    $project_name = remove_junk($db->escape($name));
    $sql = "INSERT INTO projects (name) VALUES ('{$project_name}')";
    return $db->query($sql);
  }

  public static function update($id, $name)
  {
    global $db;
    $project_id = (int) $id;
    $project_name = remove_junk($db->escape($name));
    $sql = "UPDATE projects SET name='{$project_name}' WHERE id='{$project_id}'";
    return $db->query($sql);
  }

  public static function delete($id)
  {
    return delete_by_id('projects', (int) $id);
  }
}

?>

