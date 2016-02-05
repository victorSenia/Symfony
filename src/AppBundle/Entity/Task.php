<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Task {

    private $task;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    private $dueDate;

    /**
     * @Assert\Type(type="AppBundle\Entity\Category")
     * @Assert\Valid()
     */
    protected $category;

// ...
    public function getCategory() {
        return $this->category;
    }

    public function setCategory(Category $category = null) {
        $this->category = $category;
    }

    /**
     * @Assert\Length(
     *      min = "5",
     *      max = "50",
     *      minMessage = "Your task must be at least {{ limit }} characters length",
     *      maxMessage = "Your task cannot be longer than than {{ limit }} characters length"
     * , groups={"create", "update"})
     * @return type String
     */
    public function getTask() {
        return $this->task;
    }

    public function setTask($task) {
        $this->task = $task;
    }

    public function getDueDate() {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null) {
        $this->dueDate = $dueDate;
    }

    /**
     * @return type boolean
     * @Assert\IsTrue(message = "It is too late for creating this task", groups={"create"})
     */
    public function isToLate() {
        return $this->getDueDate() > new \DateTime();
    }

}
