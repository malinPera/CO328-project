<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class block_learndroidnewsfeed extends block_base {

    /**
     * Initialise the block.
     */
    public function init() {
        $this->title = get_string('newsfeed_name', 'block_learndroidnewsfeed');
    }

    public function get_content() {
        global $CFG;

        require_once($CFG->dirroot.'/calendar/lib.php');

        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';

        $filtercourse    = array();
        if (empty($this->instance)) { // Overrides: use no course at all.
            $courseshown = false;
            $this->content->footer = '';

        } else {
            $courseshown = $this->page->course->id;
            
            $context = context_course::instance($courseshown);
            if (has_any_capability(array('moodle/calendar:manageentries', 'moodle/calendar:manageownentries'), $context)) {
                //the links not needed
            }
                $filtercourse = calendar_get_default_courses();
        }

        list($courses, $group, $user) = calendar_set_filters($filtercourse);//returns a list of courses

        /*calendar functions*/
        $defaultlookahead = CALENDAR_DEFAULT_UPCOMING_LOOKAHEAD;
        if (isset($CFG->calendar_lookahead)) {
            $defaultlookahead = intval($CFG->calendar_lookahead);
        }
        $lookahead = get_user_preferences('calendar_lookahead', $defaultlookahead);//gives user preferences

        $defaultmaxevents = CALENDAR_DEFAULT_UPCOMING_MAXEVENTS;
        if (isset($CFG->calendar_maxevents)) {
            $defaultmaxevents = intval($CFG->calendar_maxevents);
        }
        $maxevents = get_user_preferences('calendar_maxevents', $defaultmaxevents);
        $events = calendar_get_upcoming($courses, $group, $user, $lookahead, $maxevents);
        /*calendar functions are over*/
        
        /*viewing part*/
        if (!empty($this->instance)) {
            $link = 'view.php?view=day&amp;course='.$courseshown.'&amp;';
            $showcourselink = ($this->page->course->id == SITEID);
           
            $rawText = calendar_get_block_upcoming($events, $link, $showcourselink);
          
            $this->content->text = '<div class="post">'.$rawText.'</div>';
        }

        /*if no events*/
        if (empty($this->content->text)) {
            $this->content->text = '<div class="post">'. get_string('learnDroid_noevents', 'calendar').'</div>';
        }

        return $this->content;
    }
}
?>