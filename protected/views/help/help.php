<?php
    // show profile of student
    $this->showProfileFor = $student;
?>

<h2>Help Section</h2>
<p>
</br>	
 <strong>APPLIX </strong> is Mnemonic’s university application portal that provides you with the lucid view of your application progress.
</p>
<p>The portal aims to simplify the rigors involved in the application process by providing you with the transparency you need to track your application status with Mnemonic Education. Applix gives you everything you need for hassle free application process. 
	Our secured application portal allows you the direct communication with our team involved in achieving your 'Mission Admission'.</p>
<p>This is a brief document to help you familiarize with Applix Features.</p>

<p>There are four main sections you will see on the left:</p>

<ol>	
<li>Profile</li>
<li>Applications</li>
<li>Documents</li>
<li>Activity</li>
</ol>	

<h3><u>Profile:</u></h3>
	    <p>This page contains <?php echo CHtml::link('information about you',array('user/view','id'=>Yii::app()->user->id));?> – your contact details, academic record, countries of interest, etc. 
		This information is essential for us to shortlist and complete your applications. Hence, please keep this page up to date. 
		You can edit existing details as well as add new details. You'll find some pre-defined fields, but you can add any other info that you may want to.
	   </p>

<h3><u>Applications:</u></h3>
	<p>
	 	This section lists all your <?php echo CHtml::link('applications', array('application/index','student_id'=>Yii::app()->user->id)); ?> along-with their deadlines.
	 	 A quick glance at the list will also show you the progress of each application as well as it's current state. 
	 	Click on an application to view the following information - 
	 </p>
<ul>
	<li><strong>Checklist – </strong></li>
			<p>The checklist is a list of steps that need to be completed in order to complete your application. 
			 This list is managed by us.
			 As more items in the checklist of a university application are marked as complete, that application itself approaches completion.
			</p>

	<li><strong>Details – </strong></li>
			<p> This section contains pertinent information about the university – such as it's score requirements, fee,l login credentials and url, location, etc. Of these, you are required to provide the login details and url of the university if applicable.
			</p>
	<li><strong>Activity –</strong></li>
			<p>  Shows a history of all actions performed under this university.
			</p>
</ul>	
<h3><u>Documents:</u></h3>
		<p>
		This section contains all the <?php echo CHtml::link('documents', array('document/index','student_id'=>Yii::app()->user->id)); ?> related to you and your applications. 
		Check this section often to see what documents are required for your admission.
		</p>
        <p>
        Kindly upload your school/college transcripts, passport copy, exam scores and other relevant documents as soon as you start working with Applix.
        </p>	
<h3><u>Activity:</u></h3>     
		<p>
        This tracks the <?php echo CHtml::link('activity', array('activity/index','student_id'=>Yii::app()->user->id)); ?> across all your applications.
        This is a higher level of tracking than the activity inside a particular application.
        </p>

<h3><u>Menu Bar</u></h3>
        <p>On top bar you will see three things:
        </p>
			<ol>
				<li>	Messages</li>
				<li>	Tasks </li>
			    <li>	Notifications</li>
			</ol>

<h3><u>Messages:</u></h3>
		<p>
			This is where you can see your messages. You can compose a message to your manager(s) by using the red button on the top right. 
			You will also find the message button towards the left on the Profile, Applications, Documents and Activity page.
		</p>	
<h3><u>Task:</u></h3>
		<p>
			Often, you will be asked to complete certain jobs – like writing drafts for essays and LORs,  creating your online university account, or even something simple as editing / adding some information on your profile.
			These will be assigned to you formally as Tasks. The tasks page lists all the tasks you've received.
			A task has a subject, description / instructions, an activity log / messaging system, and a place to attach documents.
            You can mark a task as not-started (default), in-progress and complete. Your goal is to finish all of your incoming tasks and mark them as complete as soon as possible. You can also assign a task to one of your managers using the button on the top right. You will also find the task button towards the left on the Profile, Applications, Documents and Activity page.
		</p>
<h3><u>Notifications:</u></h3>		
		<p>
			All of the activity performed in regard to your profile and applications will also be sent to you as notifications.
			 You can dismiss them individually or all at once. 
			Do check this page often and dismiss notifications after reading, so that you know what your latest updates are.
		</p>	