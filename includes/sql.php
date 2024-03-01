<?php
require_once('load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table));
  }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
  return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table, $id)
{
  global $db;
  $id = (int) $id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table (supplier id)
/*--------------------------------------------------------------*/
function find_supplier_by_id($id)
{
  global $db;
  $id = (int) $id;
  $table = 'supplier';
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE SUPPLIER_ID='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}
/*--------------------------------------------------------------*/
/*  Function for Find data from products by id
/*--------------------------------------------------------------*/
function find_products_by_id($id)
{
  global $db;
  $table = 'products';
  $id = (int) $id;
  if (tableExists($table)) {
    $sql = "SELECT * FROM {$db->escape($table)} WHERE prod_id='{$db->escape($id)}' LIMIT 1";
    return find_by_sql($sql);
  }
}
/*--------------------------------------------------------------*/
/*  Function for Find data from departments by id
/*--------------------------------------------------------------*/
function find_dep_by_id($id)
{
  global $db;
  $table = 'departments';
  $id = (int) $id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE dep_id='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table, $id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "DELETE FROM " . $db->escape($table);
    $sql .= " WHERE id=" . $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table)
{
  global $db;
  if (tableExists($table)) {
    $sql = "SELECT COUNT(id) AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_cart_items($table, $id)
{
  global $db;
  $user_id = $_SESSION['user_id'];
  if (tableExists($table)) {
    $sql = "SELECT * FROM $table WHERE user_id = $user_id AND item_status = 0";
    $result = $db->query($sql);
    return ($db->num_rows($result));


  }
}
function count_products($table)
{
  global $db;
  if (tableExists($table)) {
    $sql = "SELECT COUNT(prod_id) AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_different($table, $column)
{
  global $db;
  $col = $column;
  if (tableExists($table)) {
    $sql = "SELECT COUNT($col) AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* count items in a table
/*--------------------------------------------------------------*/
function count_items($table)
{
  global $db;
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM $table WHERE user_id = $user_id";
  $result = $db->query($sql);
  return ($db->num_rows($result));
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table)
{
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM ' . DB_NAME . ' LIKE "' . $db->escape($table) . '"');
  if ($table_exit) {
    if ($db->num_rows($table_exit) > 0)
      return true;
    else
      return false;
  }
}
/*--------------------------------------------------------------*/
/* Login with the data provided in $_POST,
/* coming from the login form.
/*--------------------------------------------------------------*/
function authenticate($username = '', $password = '')
{
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if ($password_request === $user['password']) {
      return $user['id'];
    }
  }
  return false;
}
/*--------------------------------------------------------------*/
/* Login with the data provided in $_POST,
/* coming from the login_v2.php form.
/* If you used this method then remove authenticate function.
/*--------------------------------------------------------------*/
function authenticate_v2($username = '', $password = '')
{
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if ($password_request === $user['password']) {
      return $user;
    }
  }
  return false;
}


/*--------------------------------------------------------------*/
/* Find current log in user by session id
/*--------------------------------------------------------------*/
function current_user()
{
  static $current_user;
  global $db;
  if (!$current_user) {
    if (isset($_SESSION['user_id'])):
      $user_id = intval($_SESSION['user_id']);
      $current_user = find_by_id('users', $user_id);
    endif;
  }
  return $current_user;
}
/*--------------------------------------------------------------*/
/* Find all user by
/* Joining users table and user gropus table
/*--------------------------------------------------------------*/
function find_all_user()
{
  global $db;
  $results = array();
  $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,u.department,";
  $sql .= "g.group_name ";
  $sql .= "FROM users u ";
  $sql .= "LEFT JOIN user_groups g ";
  $sql .= "ON g.group_level=u.user_level ORDER BY u.name ASC";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------------------------*/
/* Function to update the last log in of a user
/*--------------------------------------------------------------*/

function updateLastLogIn($user_id)
{
  global $db;
  $date = make_date();
  $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
  $result = $db->query($sql);
  return ($result && $db->affected_rows() === 1 ? true : false);
}

/*--------------------------------------------------------------*/
/* Find all Group name
/*--------------------------------------------------------------*/
function find_by_groupName($val)
{
  global $db;
  $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*--------------------------------------------------------------*/
/* Find all Department name
/*--------------------------------------------------------------*/
function find_by_depName($val)
{
  global $db;
  $sql = "SELECT dep_name FROM departments WHERE dep_name = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*--------------------------------------------------------------*/
/* Find group level
/*--------------------------------------------------------------*/
function find_by_groupLevel($level)
{
  global $db;
  $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*--------------------------------------------------------------*/
/* Find department head
/*--------------------------------------------------------------*/
function find_dep_head($level)
{
  global $db;
  $sql = "SELECT dep_head FROM departments WHERE dep_head = '{$db->escape($level)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*--------------------------------------------------------------*/
/* Find user's department
/*--------------------------------------------------------------*/
function find_user_department($id)
{
  global $db;
  $uid = (int) $id;
  $sql = "SELECT department FROM ";
  $sql .= "users ";
  $sql .= " WHERE id= '{$db->escape($uid)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result));
}
/*--------------------------------------------------------------*/
/* Function for cheaking which user level has access to page
/*--------------------------------------------------------------*/
function page_require_level($require_level)
{
  global $session;
  $current_user = current_user();
  $login_level = find_by_groupLevel($current_user['user_level']);
  //if user not login
  if (!$session->isUserLoggedIn(true)):
    $session->msg('d', 'Please login...');
    redirect('../index.php', false);
    //if Group status Deactive
  elseif ($login_level === '0'):
    $session->msg('d', 'This level user has been banned!');
    redirect('../index.php', false);
    //cheackin log in User level and Require level is Less than or equal to
  elseif ($current_user['user_level'] <= (int) $require_level):
    return true;
  else:
    $session->msg("d", "Sorry! you dont have permission to view the page.");
    redirect('../index.php', false);
  endif;

}
/*--------------------------------------------------------------*/
/* Function for Finding all product name
/* JOIN with categorie  and media database table
/*--------------------------------------------------------------*/
function join_product_table()
{
  global $db;
  $sql = " SELECT p.prod_id,p.prod_name,p.quantity,p.buy_price,p.unit,p.over_stock,p.low_stock, p.media_id,p.date,p.prod_code,c.name";
  $sql .= " AS categorie,m.file_name AS image";
  $sql .= " FROM products p";
  $sql .= " LEFT JOIN categories c ON c.id = p.categorie_id";
  $sql .= " LEFT JOIN media m ON m.id = p.media_id";
  $sql .= " ORDER BY p.prod_id ASC";
  return find_by_sql($sql);

}
/*--------------------------------------------------------------*/
/* Function for Finding all product name
/* Request coming from ajax.php for auto suggest
/*--------------------------------------------------------------*/

function find_product_by_title($product_name)
{
  global $db;
  $p_name = remove_junk($db->escape($product_name));
  $sql = "SELECT prod_name FROM products WHERE prod_name like '%$p_name%' LIMIT 5";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Function for Finding all product info by product title
/* Request coming from ajax.php
/*--------------------------------------------------------------*/
function find_all_product_info_by_title($title)
{
  global $db;
  $sql = "SELECT p.prod_id,p.prod_name,p.quantity,p.buy_price,p.unit,p.media_id,p.date,p.prod_code,c.name";
  $sql .= " AS categorie,m.file_name AS image";
  $sql .= " FROM products p";
  $sql .= " LEFT JOIN categories c ON c.id = p.categorie_id";
  $sql .= " LEFT JOIN media m ON m.id = p.media_id";
  $sql .= " WHERE prod_name ='{$title}'";
  $sql .= " LIMIT 1";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Update product quantity
/*--------------------------------------------------------------*/
function update_product_qty($qty, $p_id)
{
  global $db;
  $qty = (int) $qty;
  $id = (int) $p_id;
  $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE prod_id = '{$id}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);

}
/*--------------------------------------------------------------*/
/* Function for Display Recent product Added
/*--------------------------------------------------------------*/
function find_recent_product_added($limit)
{
  global $db;
  $sql = " SELECT p.prod_id,p.prod_name,p.buy_price, c.name AS category";
  $sql .= " FROM products p";
  $sql .= " LEFT JOIN categories c ON c.id = p.categorie_id";
  $sql .= " ORDER BY p.prod_id DESC LIMIT " . $db->escape((int) $limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Find Highest saleing Product
/*--------------------------------------------------------------*/
function find_highest_requested_product($limit)
{
  global $db;
  $sql = "SELECT p.prod_name, COUNT(s.item_id) AS totalSold, SUM(s.qty) AS totalQty";
  $sql .= " FROM store_requisitions s";
  $sql .= " LEFT JOIN products p ON p.prod_id = s.item_id ";
  $sql .= " GROUP BY s.item_id";
  $sql .= " ORDER BY SUM(s.qty) DESC LIMIT " . $db->escape((int) $limit);
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for find all sales
/*--------------------------------------------------------------*/
function find_all_sale()
{
  global $db;
  $sql = "SELECT s.id,s.qty,s.price,s.date,p.prod_name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.prod_id";
  $sql .= " ORDER BY s.date DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for find all store_requisitions
/*--------------------------------------------------------------*/

function find_new_requests()
{
  global $db;
  $sql = "SELECT s.request_id, s.qty, s.timestamp, p.prod_name,p.prod_id, p.buy_price, u.name,s.measurement,u.department";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id ";
  $sql .= "WHERE s.approved_by IS NULL ";
  $sql .= "ORDER BY s.timestamp DESC";
  return find_by_sql($sql);
}

function view_all_approved_request()
{
  global $db;
  $sql = "SELECT s.request_id, s.qty, s.timestamp, p.prod_name,p.prod_id, p.buy_price, u.name, u.department";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id ";
  $sql .= "WHERE s.approved_by IS NOT NULL AND s.approved_by != 'Declined' AND s.issued_by IS NULL";
  $sql .= " ORDER BY s.timestamp DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for finding all history
/*--------------------------------------------------------------*/

function find_request_history()
{
  global $db;
  $sql = "SELECT s.request_id, s.qty, s.timestamp, p.prod_name,p.prod_id, p.buy_price, u.name,s.measurement,u.department,s.approved_by";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id ";
  $sql .= "WHERE s.approved_by IS NOT NULL AND s.approved_by !='Declined' ";
  $sql .= "ORDER BY s.timestamp DESC";
  return find_by_sql($sql);

}

/*--------------------------------------------------------------*/
/* Function for findding all history
/*--------------------------------------------------------------*/

function find_issue_history()
{
  global $db;
  $sql = "SELECT s.request_id, s.qty, s.timestamp, p.prod_name,p.prod_id, p.buy_price, u.name,s.measurement,u.department,s.approved_by";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id ";
  $sql .= "WHERE s.issued_by IS NOT NULL AND s.issued_by != 'Declined' ";
  $sql .= "ORDER BY s.timestamp DESC";
  return find_by_sql($sql);

}

function find_store_requisitions()
{
  global $db;
  $sql = "SELECT s.request_id, s.qty, s.timestamp, p.prod_name,p.prod_id, p.buy_price, u.name";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id ";
  $sql .= "WHERE approved_by != 'Null' AND 'denied'";
  $sql .= " ORDER BY s.timestamp DESC";
  return find_by_sql($sql);
}

function find_my_request_history()
{
  global $db;
  $my_id = $_SESSION['user_id'];
  $sql = "SELECT s.request_id, s.qty, s.timestamp,s.approved_by, p.prod_name,p.prod_id, p.buy_price, u.name, s.issued_by, s.measurement, u.department, s.confirmed";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id ";
  $sql .= "WHERE s.user_id = $my_id  AND ( s.approved_by = 'Declined' OR s.issued_by = 'Declined' OR s.issued_by  REGEXP '[0-9]') OR (s.issued_by IS NULL)";
  $sql .= " ORDER BY s.timestamp DESC";
  return find_by_sql($sql);
}
function find_requisitions_history()
{
  global $db;
  $sql = "SELECT s.request_id, s.qty, s.timestamp,s.approved_by, p.prod_name,p.prod_id, p.buy_price, u.name";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id ";
  $sql .= "WHERE s.approved_by != 'Null'";
  $sql .= " ORDER BY s.timestamp DESC";
  return find_by_sql($sql);
}

function get_request_by_id($id)
{
  global $db;
  $rid = (int) $id;
  $sql = "SELECT s.request_id, s.qty, s.timestamp,s.approved_by, p.prod_name,p.prod_id, p.buy_price, u.name,s.user_id, s.item_id,s.measurement,p.prod_code,u.department,s.issued_by,s.confirmed";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id ";
  $sql .= "WHERE s.request_id = '{$rid}'";
  $sql .= " LIMIT 1";
  return find_by_sql($sql);

}
/*--------------------------------------------------------------*/
/* Function for Display Recent requests
/*--------------------------------------------------------------*/
function find_recent_request_added($limit)
{
  global $db;
  $sql = "SELECT s.request_id,s.qty,s.qty,s.timestamp,p.prod_name,p.buy_price";
  $sql .= " FROM store_requisitions s";
  $sql .= " LEFT JOIN products p ON s.item_id = p.prod_id";
  $sql .= " ORDER BY s.timestamp DESC LIMIT " . $db->escape((int) $limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Display Recent requests
/*--------------------------------------------------------------*/
function find_recent_issued($limit)
{
  global $db;
  $sql = "SELECT s.request_id,s.qty,s.qty,s.timestamp,p.prod_name,p.buy_price";
  $sql .= " FROM store_requisitions s";
  $sql .= " LEFT JOIN products p ON s.item_id = p.prod_id";
  $sql .= " WHERE s.issued_by != null";
  $sql .= " ORDER BY s.timestamp DESC LIMIT " . $db->escape((int) $limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate  report by two dates
/*--------------------------------------------------------------*/
function find_report_by_dates($start_date, $end_date)
{
  global $db;
  $start_date = date("Y-m-d", strtotime($start_date));
  $end_date = date("Y-m-d", strtotime($end_date));
  $sql = "SELECT COUNT(DISTINCT p.prod_name) AS total_distinct_items, s.request_id, s.qty, s.timestamp, s.approved_by, p.prod_name, p.prod_id, p.buy_price, u.name, s.user_id, s.item_id, s.measurement , p.prod_code,u.department, s.issued_by, s.confirmed,  ";
  $sql .= "COUNT(s.request_id) AS total_records, ";
  $sql .= "COUNT(p.prod_id) AS total_items, ";
  $sql .= "SUM(s.qty) AS total_quantity, ";
  $sql .= "SUM(p.buy_price * s.qty) AS total_price";
  $sql .= " FROM store_requisitions s ";
  $sql .= "JOIN products p ON s.item_id = p.prod_id ";
  $sql .= "JOIN users u ON s.user_id = u.id";
  $sql .= " WHERE s.timestamp BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.timestamp),p.prod_name";
  $sql .= " ORDER BY DATE(s.timestamp) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function dailySales($year, $month)
{
  global $db;
  $sql = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.prod_name,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.prod_id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Monthly sales report
/*--------------------------------------------------------------*/
function monthlySales($year)
{
  global $db;
  $sql = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.prod_name,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.prod_id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for store requisition approval
/*--------------------------------------------------------------*/
function approve_request($request)
{
  global $db;
  $req_id = (int) $request;
  $man_id = $_SESSION['user_id'];

  $sql = "UPDATE  store_requisitions SET approved_by = '{$man_id}' WHERE request_id = '{$req_id}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}
/*--------------------------------------------------------------*/
/* Function for store requisition approval
/*--------------------------------------------------------------*/
function decline_request($request)
{
  global $db;
  $req_id = (int) $request;
  $sql = "UPDATE  store_requisitions SET approved_by = 'Declined' WHERE request_id = '{$req_id}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}
/*--------------------------------------------------------------*/
/* Function for store issue
/*--------------------------------------------------------------*/
function issue($request, $storeman)
{
  global $db;
  $req_id = (int) $request;
  $by = (int) $storeman;

  $req_query = "SELECT qty, item_id, quantity from store_requisitions s join products p on p.prod_id = s.item_id where request_id = $req_id";
  $reqs = $db->query($req_query);
  foreach ($reqs as $req) {

    if ($req['quantity'] >= $req['qty']) {
      $new_qty = $req['quantity'] - $req['qty'];
      $update_stock_query = "UPDATE products SET quantity = '{$new_qty}' WHERE prod_id = '{$req['item_id']}'";
      $update_result = $db->query($update_stock_query);
      $update_req_query = "UPDATE  store_requisitions SET issued_by = '{$by}' WHERE request_id = '{$req_id}'";
      $req_result = $db->query($update_req_query);
      return (true);
    } else {
      return (false);
    }
  }
}
/*--------------------------------------------------------------*/
/* Function for store issue
/*--------------------------------------------------------------*/
function decline_issue($request)
{
  global $db;
  $req_id = (int) $request;
  $sql = "UPDATE  store_requisitions SET issued_by = 'Declined' WHERE request_id = '{$req_id}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}
/*--------------------------------------------------------------*/
/* Function for store issue confirmation
/*--------------------------------------------------------------*/
function confirm_issue($request, $user)
{
  global $db;
  $req_id = (int) $request;
  $uid = (int) $user;
  $sql = "UPDATE  store_requisitions SET confirmed = '{$uid}' WHERE request_id = '{$req_id}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}
/*--------------------------------------------------------------*/
/* Function for notification seen
/*--------------------------------------------------------------*/
function update_seen()
{
  global $db;
  $sql = "UPDATE `store_requisitions` set seen = '1' where seen = '0'";
  $result = $db->query($sql);
  return ($result && $db->affected_rows() === 1 ? true : false);
}

function select_notifications()
{
  global $db;
  $sql = "SELECT * from 'store_requisitions' order by timestamp desc limit 10 ";
  $result = $db->query($sql);
  return ($db->num_rows($result));
}
function select_unseen()
{
  global $db;
  $sql = "SELECT * from `store_requisitions` where seen ='0'";
  $result = $db->query($sql);
  return ($db->num_rows($result));
}
/*--------------------------------------------------------------*/
/* Function for Finding purchase order info
/*--------------------------------------------------------------*/
function find_supplier_info($sid)
{
  global $db;
  $id = (int) $sid;
  $result = '';
  $sql = $db->query("SELECT COMPANY_NAME from `supplier` WHERE `SUPPLIER_ID`= $id");
  if ($sql->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $sql->fetch_assoc();
    $result = $row["COMPANY_NAME"];
    return $result;
  } else {
    return '';
  }
}
function find_user_info($uid)
{
  global $db;
  $id = (int) $uid;
  $result = '';
  $sql = $db->query(" SELECT `name` from `users` WHERE `id`= $id");
  if ($sql->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $sql->fetch_assoc();
    $result = $row["name"];
    return (string) $result;
  } else {
    return '';
  }
}
function find_product_by_code($code)
{
  global $db;
  // Sanitize input to prevent SQL injection
  // $id = (int) $code;
  $result = '';
  $sql = $db->query("SELECT prod_name FROM `products` WHERE prod_code='{$db->escape($code)}' LIMIT 1");
  if ($sql->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $sql->fetch_assoc();
    $result = $row["prod_name"];
    return (string) $result;
  } else {
    return '';
  }
}

function find_po_history()
{
  global $db;
  $ID = $_SESSION['user_id'];
  $sql = "SELECT p.*, s.COMPANY_NAME as supplier FROM `purchase_order_list` p inner join supplier s on p.supplier_id = s.SUPPLIER_ID order by p.`date_created` desc";


  return find_by_sql($sql);
}

function items_in_cart()
{
  global $db;
  $ID = $_SESSION['user_id'];
  $sql = "SELECT c.item_id,p.prod_name,p.prod_id, p.buy_price,u.id,u.name,p.prod_code,c.quantity,p.unit";
  $sql .= " FROM cart c ";
  $sql .= "JOIN products p ON c.prod_id = p.prod_id ";
  $sql .= "JOIN users u ON c.user_id = u.id ";
  $sql .= "WHERE c.user_id = '{$ID}'";
  $sql .= " ORDER BY c.item_id";
  return find_by_sql($sql);
}
function po_items_in_cart()
{
  global $db;
  $ID = $_SESSION['user_id'];
  $sql = "SELECT c.item_id,c.list_id,p.prod_name,p.prod_id, p.buy_price,u.id,u.name,p.prod_code,c.quantity,p.unit";
  $sql .= " FROM  po_items c ";
  $sql .= "JOIN products p ON c.item_id = p.prod_id ";
  $sql .= "JOIN users u ON c.user_id = u.id ";
  $sql .= "WHERE c.user_id = '{$ID}' AND c.item_status = 0";
  $sql .= " ORDER BY c.item_id";
  return find_by_sql($sql);
}


function low_stock()
{
  global $db;
  $sql = "SELECT p.prod_id,p.prod_name, p.buy_price,p.prod_code,p.quantity,p.unit,p.low_stock, s.COMPANY_NAME ";
  $sql .= " FROM products p ";
  $sql .= "JOIN supplier s ON p.supplier_id = s.SUPPLIER_ID ";
  $sql .= "WHERE p.quantity <= p.low_stock ";
  $sql .= " ORDER BY p.prod_id";

  return find_by_sql($sql);
}

function find_po_by_id($po_id)
{
  global $db;
  $sql = "SELECT p.*,o.list_id,o.quantity as po_quantity,o.user_id,o.po_id,u.name from po_items o join purchase_order l on l.po_id = o.po_id join products p on p.prod_id = o.item_id join users u on u.id = o.user_id where o.po_id=$po_id ";
  return find_by_sql($sql);
}
function find_two_($id)
{
  $po_id = (int) $id;
  global $db;
  $sql = "SELECT p.*,s.SUPPLIER_ID,s.COMPANY_NAME from purchase_order p join supplier s on p.supplier_id = s.SUPPLIER_ID where p.po_id = $po_id";
  return find_by_sql($sql);
}

