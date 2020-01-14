<?php
    require 'session_required.php';
    require 'connection.php';
    $expenseDetails = $expense->getExpenseById($_GET['id']);
    $expense->deleteExpense($_GET['id']);
    $logDetails = 'Expense amount '.$expenseDetails['amount'].' ,issued to '.$expenseDetails['expenseTo'].' ,for '.$expenseDetails['expensePurpose'].' has been deleted by '.$_SESSION['adminName'];
    $created = date('Y-m-d H:i:s');
    $log->addLog($logDetails,$_SESSION['adminId'],$created);
    $_SESSION['message'] = 'Expense Deleted';
    header('location:expenses.php');
?>