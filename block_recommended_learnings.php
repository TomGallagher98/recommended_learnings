<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Recommended Learnings Block
 *
 * @package    block_recommended_learnings
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_recommended_learnings extends block_list {
    public function init() {
        $this->title = get_string('pluginname', 'block_recommended_learnings');
    }
    //returns the content to be displayed in the block
    public function get_content(){
        //returns content if there is already content defined
        if ($this->content !== null) {
            return $this->content;
        }
        //Calls an instance of the global moodle database
        global $DB;

        $this->content = new stdClass;
        //Returns current course categories in the database, these will be used to match recommendations
        $courses = get_courses();
        foreach ($courses as $id=>$course) {
            //queries the course_categories database, returns the category
            $category = $DB->get_record('course_categories',array('id'=>$course->category));
            $course->categoryName = $category->name;
            //stores the course and category within a object
            $allcourses[$id] = $course;
        }
        //Add search element using categories in all courses block
        //Return the recommendations and display them

        //The following code will depend on how the recommendation search returns data 
        foreach ($allcourses as $id=>$course) {
            //returns a link
            //intended to display a page with the content of the recommended feature, however linked only to a base file at the moment
            $this->content->items[] = html_writer::tag('a', $course->categoryName, array('href' => '/blocks/testblock/some_file.php'));

        }        
        //returns and displays the stored content
        return $this->content;
    }

    //Allows the block to be edited in the edit_form.php document
    public function specialization() {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_recommended_learnings');
            } else {
                $this->title = $this->config->title;
            }

            if (empty($this->config->text)) {
                $this->congif->text = get_string('defaulttext', 'block_recommended_learnings');
            }
        }
    }
}
