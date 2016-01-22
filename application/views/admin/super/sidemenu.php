<?php
   /**
    * This view displays the sidemenu on the left side, containing the question explorer
    *
    * Var to manage open/close state of the sidemenu, question explorer :
    * @var $sidemenu['state'] : if set, the sidemnu is close
    * @var $sidemenu['explorer']['state'] : if set to true, question explorer will be opened
    */
?>
<?php
    // TODO : move to controller
    $bSurveyIsActive = (isset($surveyIsActive))?$surveyIsActive:$oSurvey->active=='Y';
    $sidemenu = (isset($sidemenu))?$sidemenu:array();
?>

    <!-- State when page is loaded : for JavaScript-->
    <?php if(isset($sidemenu['state']) && $sidemenu['state']==false ):?>
       <input type="hidden" id="close-side-bar" />
    <?php endif;?>

    <!-- To handle correctly the side menu positioning -->
    <div class="absolute-wrapper hidden-xs" style="z-index: 100;"> </div>

    <!-- sideMenu -->
    <div class="side-menu  hidden-xs" id="sideMenu" style="z-index: 101;">

        <nav class="navbar navbar-default  hidden-xs" role="navigation">

            <!-- Header : General -->
            <div class="navbar-header  hidden-xs">
                <div class="brand-wrapper  hidden-xs">

                    <!-- Hamburger for futur mobile design-->
                    <button type="button" class="navbar-toggle hidden-xs">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <div class='row'>

                        <!-- Brand -->
                        <div class='col-sm-8'>
                            <div class="brand-name-wrapper  hidden-xs">
                                <a class="navbar-brand hideside toggleside" href="#">
                                    <?php eT('General');?>
                                </a>
                            </div>
                        </div>

                        <!-- chevrons to stretch the side menu -->
                        <div class='col-sm-2'>
                            <a class="btn btn-default hide-button hidden-xs opened" id="chevronClose">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                        </div>
                        <div class='col-sm-2'>
                            <a class="btn btn-default hide-button hidden-xs opened" id="chevronStretch">
                                <span class="glyphicon glyphicon-chevron-right" ></span>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Main Menu -->
            <div class="side-menu-container  hidden-xs">
                <ul class="nav navbar-nav sidemenuscontainer  hidden-xs">

                    <!-- Link to survey summary-->
                    <li class="toWhite <?php if( isset($sidemenu["survey_menu"]) ) echo 'active'; ?> ">
                        <a href="<?php echo $this->createUrl("admin/survey/sa/view/surveyid/$surveyid"); ?>">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php eT("Survey");?>
                        </a>
                    </li>

                    <!-- Question & Groups-->
                    <li class="panel panel-default dropdownlvl1" id="dropdown">
                        <a data-toggle="collapse" id="questions-groups-collapse" href="#dropdown-lvl1" <?php if( isset($sidemenu["questiongroups"]) ) echo 'aria-expanded="true"'; ?>  >
                            <span class="glyphicon glyphicon-folder-open"></span> <?php eT('Questions and groups:');?>
                            <span class="caret"></span>
                        </a>

                        <!-- Question Explorer -->
                        <div id="dropdown-lvl1" class="panel-collapse collapse <?php if( isset($sidemenu["questiongroups"]) || isset($sidemenu["listquestions"]) || 1==1 ) echo 'in'; ?>"  <?php if( isset($sidemenu["questiongroups"]) || isset($sidemenu["listquestions"]) ) echo 'aria-expanded="true"'; ?> >
                            <div class="panel-body">
                                <ul class="nav navbar-nav dropdown-first-level">
                                    <!-- Explorer -->
                                    <?php $this->renderPartial( "/admin/super/_question_explorer", array(
                                        'sidemenu' => $sidemenu,
                                        'aGroups' => $aGroups,
                                        'iSurveyId' => $surveyid,
                                        'bSurveyIsActive' => $bSurveyIsActive
                                    )); ?>

                                    <?php if($permission):?>
                                        <!-- List Groups -->
                                        <li class="toWhite <?php if( isset($sidemenu["listquestiongroups"]) ) echo 'active'; ?>">
                                            <!-- admin/survey/sa/view/surveyid/838454 listquestiongroups($iSurveyID)-->
                                            <a href="<?php echo $this->createUrl("admin/survey/sa/listquestiongroups/surveyid/$surveyid"); ?>">
                                                <span class="glyphicon glyphicon-list"></span>
                                                <?php eT("List question groups");?>
                                            </a>
                                        </li>

                                        <!-- List Questions -->
                                        <li class="toWhite <?php if( isset($sidemenu["listquestions"]) ) echo 'active'; ?>">
                                            <a href="<?php echo $this->createUrl("admin/survey/sa/listquestions/surveyid/$surveyid"); ?>">
                                                <span class="glyphicon glyphicon-list"></span>
                                                <?php eT("List questions");?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!-- Organize questions -->
                                    <?php if($surveycontent):?>
                                        <?php if ($activated):?>
                                            <li class="disabled">
                                                <a href='#'>
                                                    <span class="icon-organize"></span>
                                                    <?php eT("Question group/question organizer disabled"); ?> - <?php eT("This survey is currently active."); ?>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a href="<?php echo $this->createUrl("admin/survey/sa/organize/surveyid/$surveyid"); ?>">
                                                    <span class="icon-organize"></span>
                                                    <?php eT("Reorder question groups / questions"); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif;?>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- Token -->
                    <?php if($tokenmanagement):?>
                        <li id="tokensidemenu" class="toWhite  <?php if( isset($sidemenu["token_menu"]) ) echo 'active'; ?> ">
                            <a href="<?php echo $this->createUrl("admin/tokens/sa/index/surveyid/$surveyid"); ?>">
                                <span class="glyphicon glyphicon-user"></span>
                                <?php eT("Token management");?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Survey List -->
                    <li class="toWhite" >
                        <a href="<?php echo $this->createUrl("admin/survey/sa/listsurveys/"); ?>" class="" >
                            <span class="glyphicon glyphicon-step-backward"></span>
                            <?php eT("Return to survey list");?>
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
 </div>