<?php
class EmployeesToDoGateway extends TableDataGateway {
public function __construct($connect) {
parent::__construct($connect);
}
protected function getSelectStatement()
{

return "SELECT * FROM EmployeeToDo INNER JOIN Employees ON Employees.EmployeeID = EmployeeToDo.EmployeeID ";
  
}
protected function getOrderFields() {
return 'EmployeeToDo.DateBy DESC, FirstName';
}
protected function getPrimaryKeyName() {
return "Employees.EmployeeID";
}
}
?>