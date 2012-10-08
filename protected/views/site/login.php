<div class="row-fluid">
    <div class="span8">
        <br /><br />
        <h1>Applix.</h1>
        <br /><br />
        <p class="lead">
        Welcome to Applix, your own university application portal which provides you with the lucid view
        of your application progress.
        </p>

        <p>The portal aims to simplify the rigors involved in the application
        process by providing you with the transparency you need to track your application status with
        Mnemonic Education.
        Applix gives you everything you need for hassle free application process. Our
        secured application portal allows you the direct communication with our team involved in achieving
        your <em>'Mission Admission'</em>.
        </p>

        <p>
        So be ready to Apply through Applix and <strong>let’s get your Application started!</strong>
        </p>
    </div>

    <div class="span4">
        <br /><br />
        <div class="form">

        <?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm', array(
            'id'=>'login-form-login-form',
            'enableAjaxValidation'=>true,
            'htmlOptions'=>array('class'=>'well'),
        )); ?>
            <h3>Sign in</h3>
            <br />

            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'email'); ?>

            <?php echo $form->passwordFieldRow($model,'password'); ?>

            <?php echo $form->checkboxRow($model,'rememberMe'); ?>

            <br />
            <?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'size'=>'large', 'type'=>'success', 'label'=>'Sign in')); ?>

        <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>
</div>
