<?php
class UniversityGateway extends TableDataGateway {
public function __construct($connect) {
parent::__construct($connect);
}
protected function getSelectStatement()
{
return "SELECT Name, Address, City, Website, Longitude, Latitude, UniversityID, Zip, State from Universities";
}
protected function getOrderFields() {
return 'Name limit 20 ';
}
protected function getPrimaryKeyName() {
return "State";
}
protected function getSecondaryKeyName() {
return "UniversityID";
}
}
?>