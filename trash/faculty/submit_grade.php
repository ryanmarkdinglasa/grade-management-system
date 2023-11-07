<?php
session_start();
include("../include/function.php");
include("../include/conn.php");

if(isset($_POST['submit_grade'])){
    $class_id=trim($_POST['class_id']);
    $period=trim($_POST['period']);
    $sql="SELECT `student`.`username`FROM `participants`
        INNER JOIN `student` ON `student`.`id` = `participants`.`student_id`
     WHERE `class_id`=:class_id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
	$stmt->execute();
	$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $array_email= array();
    foreach ($students as $student) {
        $array_email[] = $student['username']; // Use [] to append elements to the array
    }
    $note = "Dear valued student,
    \nWe are pleased to inform you that your $period grade has been successfully posted on the PhilSCA portal. Kindly access the portal to view your grade and academic progress. Your continuous dedication and commitment to your studies are commendable. We believe that your hard work will continue to yield positive results. Should you have any questions or concerns regarding your grade or academic matters, please do not hesitate to reach out to our academic advisors.

    Thank you for being an integral part of the PhilSCA community. We wish you continued success in your academic journey.

    Best regards,
    Program Coordinator
    Philippine State College of Aeronautics (PhilSCA)";

    $_SESSION['success']="Grdes are submitted.";
    if($period=='prelim'){
        $isgrade='isPrelim';
    }else if($period=='midterm'){
        $isgrade='isMidterm';
    }else if($period=='final'){
        $isgrade='isFinal';
    }

    if (send_multipleEmails($array_email, $note)) {
        $status_value=2;$period_value=1;
        $sql = "UPDATE `isgraded` SET `".$isgrade."` = :_status WHERE `class_id` = :class_id AND `" . $isgrade . "` = :_period";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->bindParam(':_status', $status_value, PDO::PARAM_INT); // Replace $status_value with the appropriate value
        $stmt->bindParam(':_period', $period_value, PDO::PARAM_INT); // Replace $period_value with the appropriate value
        $stmt->execute();
        $_SESSION['success']="Grdes are submitted.";
        echo "<script>window.location.href='grade.php'</script>";
        exit();
    } else {
        $_SESSION['error']="Something went wrong/failure submitting grade.";
        echo "<script>window.location.href='grade.php'</script>";
        exit();
    }
}else{
    $_SESSION['error']="Something went wrong submitting grade.";
    echo "<script>window.location.href='grade.php'</script>";
    exit();
}

?>