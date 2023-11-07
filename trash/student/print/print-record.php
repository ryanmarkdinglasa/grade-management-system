<?php
error_reporting(0);
require('fpdf/fpdf.php');
class PDF extends FPDF {
  function Header() {
    // Logo
	  //left top size
    $this->Image('logo1.png', 10, 2, 110);
    // Arial bold 15
    $this->SetFont('Arial', 'B', 15);
    // Move to the right
    $this->Cell(10);
    // Line break
    $this->Ln(20);
  }

  function Footer() {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial', 'I', 8);
    // Page number
    $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }
}
if (isset($_POST['print']))  {
$levelId=$_POST['level'];
$sessionId=$_POST['session'];
$departmentId=$_POST['department'];
$facultyId=$_POST['faculty'];
// Create new FPDF instance
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
  // Add table headers
  $pdf->Cell(10, 10, '#', 1, 0, 'C');
  $pdf->Cell(50, 10, 'Student Name', 1, 0, 'C');
  $pdf->Cell(30, 10, 'ID Number', 1, 0, 'C');
  $pdf->Cell(80, 10, 'Department', 1, 0, 'C');
  $pdf->Cell(70, 10, 'Course', 1, 0, 'C');
  $pdf->Cell(40, 10, 'Year', 1, 1, 'C');
  
  $con=mysqli_connect("localhost", "root", "", "dbsims");
  // Query database and add table rows
  $ret = mysqli_query($con, "SELECT tblstudent.Id, tblstudent.firstName, tblstudent.lastName, tblstudent.otherName, tblstudent.matricNo, tblstudent.dateCreated, tbllevel.levelName, tblfaculty.facultyName, tbldepartment.departmentName, tblsession.sessionName, tblstudent.levelId, tblstudent.sessionId, tblstudent.facultyId, tblstudent.departmentId
    FROM tblstudent
    INNER JOIN tbllevel ON tbllevel.Id = tblstudent.levelId
    INNER JOIN tblsession ON tblsession.Id = tblstudent.sessionId
    INNER JOIN tblfaculty ON tblfaculty.Id = tblstudent.facultyId
    INNER JOIN tbldepartment ON tbldepartment.Id = tblstudent.departmentId
    WHERE tblstudent.levelId = '$levelId' AND tblstudent.sessionId = '$sessionId' AND tblstudent.departmentId = '$departmentId' AND tblstudent.facultyId = '$facultyId'");
  $i=1;
  while ($row = mysqli_fetch_array($ret)) {
    $pdf->Cell(10, 10, $i, 1, 0, 'C');
    $pdf->Cell(50, 10, $row['firstName'] . ' ' . $row['lastName'] . ' ' . $row['otherName'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['matricNo'], 1, 0, 'C');
    $pdf->Cell(80, 10, $row['facultyName'], 1, 0, 'C');
    $pdf->Cell(70, 10, $row['departmentName'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['levelName'], 1, 1, 'C');
    $i++;
  }
  // Output PDF
  $pdf->Output();
}
else{
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial', '', 15);
  $pdf->SetTextColor(255,35,1);
  $pdf->Cell(0, 10, "*No Record Found", 0, 1);
  $pdf->SetTextColor(0,0,0);
  $pdf->Output();
}
?>