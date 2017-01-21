<?php

/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/19/17
 * Time: 11:13 AM
 */
class SampleMapping
{

    public static $contentsSample = array(
        "Content Identifier" => array(100101000, 100101000, 100101000),
        "Topic Identifier" => array(100101000, 100102000, 100102000),
        "Slide Number" => array(1, 2, 3),
        "Content Type" => array("description", "question", "example"),
        "Topic Content" => array("A set is well-defined  collection of objects (eg numbers, letters etc) put inside a curly bracket {}. All sets have names, which are usually denoted by capital letters eg X, Y, A, B etc.", 100101001, "Suppose you define some sets as follows : C = {the four seasons of the year } D = {spring, summer , fall, winter} E = {fall, spring, summer, winter} F = {summer, spring, summer, fall, winter, winter, fall, summer} Set C gives a clear rule describing a set. Set D explicitly lists the four elements in C. Set E lists the four seasons in a different order. And set F lists the four seasons with some repetition. Thus all four sets are equal. As with numbers, you can use the equal sign to show that sets are equal.")
    );

    public static $topicSample = array(
        "Topic Identifier" => array(100101000, 100102000),
        "Topic" => array("Sets", "Equal Sets"),
        "Super Topic" => array("--", "Sets"),
        "description" => array("Little Description about sets", "Little Description about Equal Sets")
    );

    public static $questionSample = array(
        "Topic Id" => array(100101000, 100102000),
        "Question Id" => array(100101001, 100101002),
        "Question" => array("A collection of well-defined distinct objects in called", "A set N = {1,2,3 , …} is called"),
        "Question Augment" => array("--","--"),
        "Hint" => array("--", "Review Slide 3"),
        "Difficulty" => array("Easy", "Intermediate")
    );

    public static $answerSample = array(
        "Question Id" => array(100101001, 100101001, 100101001, 100101001),
        "Answer" => array("Subset", "Set", "Superset", "None of the above"),
        "isCorrect" => array(0, 1, 0, 0)
    );

    public static function getSampleData($category)
    {
        switch ($category) {
            case "topic":
                return SampleMapping::$topicSample;
                break;
            case "question":
                return SampleMapping::$questionSample;
                break;
            case "answer":
                return SampleMapping::$answerSample;
                break;
            case "content":
                return SampleMapping::$contentsSample;
                break;
            default:
                return "";
                break;
        }
    }

    public static function getSaveFunction($category)
    {
        switch ($category) {
            case "topics":
                return "saveTopic";
                break;
            case "questions":
                return "saveQuestion";
                break;
            case "answers":
                return "saveAnswer";
                break;
            case "contents":
                return "saveContent";
                break;
            default:
                return "";
                break;
        }
    }
}