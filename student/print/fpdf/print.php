<?php
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
    // Title
	//width hheight,text-inside , border
    //$this->Cell(40, 10, 'Inputs', 3, 10, 'C');
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

//if (isset($_POST['submit'])) {
  /*
  $studentId=$_POST['studentId'];
	$query1 = mysqli_query($con,
						"SELECT tblstudent.Id, tblstudent.firstName, tblstudent.lastName, tblstudent.otherName,tblstudent.matricNo,
						tblstudent.dateCreated, tbllevel.levelName,tblfaculty.facultyName,tbldepartment.departmentName,tblsession.sessionName
						from tblstudent
						INNER JOIN tbllevel ON tbllevel.Id = tblstudent.levelId
						INNER JOIN tblsession ON tblsession.Id = tblstudent.sessionId
						INNER JOIN tblfaculty ON tblfaculty.Id = tblstudent.facultyId
						INNER JOIN tbldepartment ON tbldepartment.Id = tblstudent.departmentId
						where matricNo='".$studentId."'");
  $student1 = mysqli_fetch_array($query1);
  $query2 = mysqli_query($con,"select * from tblstudent_info where matricNo='$_SESSION[viewStudentId]'");
  $student2 = mysqli_fetch_array($query2);
  $signature = ($student2['studentsignature']=='' || $student2['studentsignature']==' ')?$signature='No Signature':$signature="<img title='signature'class='img-hover' width='100px' height='50px' src='".$student2['studentsignature']." />";
  */
  $signature='yeji.jpg';
  $idno='yeji.jpg';
  $name='yeji.jpg';
  $address='yeji.jpg';
  $contactNo='yeji.jpg';
  $email='yeji.jpg';
  $department='yeji.jpg';
  $university='yeji.jpg';
  $permanentAddress='yeji.jpg';
  $birthdate='yeji.jpg';
  $birthplace='yeji.jpg';
  $status='yeji.jpg';
  $citizenship='yeji.jpg';
  $fathername='yeji.jpg';
  $foccupation='yeji.jpg';
  $mothername='yeji.jpg';
  $moccupation='yeji.jpg';
  $studentphoto='yeji.jpg';
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial', '', 12);
  $pdf->Cell(0, 10, "Student Information", 0, 1);
  // Draw a border around the image
  $pdf->Rect(155, 45, 45, 55, 'D');
  // Insert the image
  $pdf->Image($studentphoto, 157.5, 47, 40);
  $pdf->Cell(0, 0, '', 'B'); // add a bottom border
  $pdf->Ln(10); // add some vertical space
  $pdf->Cell(60, 10, "ID Number:", 0);
  $pdf->Cell(0, 10, $idno, 0, 1);
  $pdf->Cell(60, 10, "Name:", 0);
  $pdf->Cell(0, 10, $name, 0, 1);
  $pdf->Cell(60, 10, "Address:", 0);
  $pdf->Cell(0, 10, $address, 0, 1);
  $pdf->Cell(60, 10, "Contact No.:", 0);
  $pdf->Cell(0, 10, $contactNo, 0, 1);
  $pdf->Cell(60, 10, "Email:", 0);
  $pdf->Cell(0, 10, $email, 0, 1);
  $pdf->Ln(10); // add some vertical space
  // Add education section
  $pdf->Cell(0, 0  , "Education", 0, 1);
  $pdf->Cell(0, 5, '', 'B'); // add a bottom border
  $pdf->Ln(10);
  $pdf->Cell(60, 10, "Department:", 0);
  $pdf->Cell(0, 10, $department, 0, 1);
  $pdf->Cell(60, 10, "Course:", 0);
  $pdf->Cell(0, 10, "Bachelor of Science in Airplane-Airplane", 0, 1);
  $pdf->Cell(60, 10, "Year:", 0);
  $pdf->Cell(0, 10, "Second Year", 0, 1);
  $pdf->Cell(60, 10, "School:", 0);
  $pdf->Cell(0, 10, $university, 0, 1);
  $pdf->Ln(5); // add some vertical space
 
 // Add work experience section
 $pdf->Cell(0, 10, "Other Information", 0, 1);
 $pdf->Cell(0, 0, '', 'B'); // add a bottom border
 $pdf->Ln(5);
 $pdf->Cell(60, 10, "Birth Place:", 0);
 $pdf->Cell(0, 10, $birthplace, 0, 1);
 $pdf->Cell(60, 10, "Birth Date:", 0);
 $pdf->Cell(0, 10, $birthdate, 0, 1);
 $pdf->Cell(60, 10, "Permanent Address:", 0);
 $pdf->Cell(0, 10, $permanentAddress, 0, 1);
 $pdf->Cell(60, 10, "Status:", 0);
 $pdf->Cell(0, 10, $status, 0, 1);
 $pdf->Cell(60, 10, "Father's Name:", 0);
 $pdf->Cell(0, 10, $fathername, 0, 1);
 $pdf->Cell(60, 10, "Father's Occupation:", 0);
 $pdf->Cell(0, 10, $foccupation, 0, 1);
 $pdf->Cell(60, 10, "Mother's Name:", 0);
 $pdf->Cell(0, 10, $mothername, 0, 1);
 $pdf->Cell(60, 10, "Mother's Occupation:", 0);
 $pdf->Cell(0, 10, $moccupation, 0, 1); 
 $pdf->Cell(140, 10,);
 $pdf->Image($signature, 150, 240, 40,30);
 $pdf->SetFont('Arial', 'U', 12);
 $pdf->Cell(0, 15," Student's Signature ", 0, 1);
 $pdf->Output();
//if submit