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

if (isset($_POST['print']))  {
  $con=mysqli_connect("localhost", "root", "", "dbsims");
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
  $query2 = mysqli_query($con,"select * from tblstudent_info where matricNo='$studentId'");
  $student2 = mysqli_fetch_array($query2);
  $signature = ($student2['studentsignature']=='' || $student2['studentsignature']==' ')?$signature='../../img/no-signature.png':$signature='../'.$student2['studentsignature'];
  $idno=$_POST['studentId'];
  $course=$student1['departmentName'];
  $name=$student1['lastName'].', '.$student1['firstName'].' '.$student1['otherName'];
  $address=$student2['address'];
  $level=$student1['levelName'];
  $contactNo=$student2['contactNo'];
  $email=$student2['email'];
  $department=$student1['facultyName'];
  $university='Philippine State College of Aeronautics';
  $permanentAddress=$student2['address'].', '.$student2['zipcode'];
  $birthdate=$student2['birthdate'];
  $birthplace=$student2['birthplace'];
  $status=$student2['status'];
  $citizenship=$student2['citizenship'];
  $fathername=$student2['fathername'];;
  $foccupation=$student2['foccupation'];
  $mothername=$student2['mothername'];
  $moccupation=$student2['moccupation'];
  $studentphoto=($student2['studentphoto']=='')?'../../img/user.jpg':'../'.$student2['studentphoto'];
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial', '', 12);
  $pdf->Cell(0, 10, "Student Information", 0, 1);
  // Draw a border around the image
  $pdf->Rect(155, 45, 45, 55, 'D');
  // Insert the image
  $pdf->Image(''.$studentphoto.'', 157.5, 47, 40,51);
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
  $pdf->Cell(0, 10, $course, 0, 1);
  $pdf->Cell(60, 10, "Year:", 0);
  $pdf->Cell(0, 10, $level, 0, 1);
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
 $pdf->Image(''.$signature.'', 150, 240, 40,30);
 $pdf->SetFont('Arial', 'U', 12);
 $pdf->Cell(0, 15," Student's Signature ", 0, 1);
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
//if submit