<?php

namespace App\Entity;

use App\Repository\TodoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TodoListRepository::class), UniqueEntity("name", "The name you tried is already used.")]
class TodoList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'todoList', targetEntity: Task::class, orphanRemoval: true)]
    private $taskId;

    public function __construct()
    {
        $this->taskId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTaskId(): Collection
    {
        return $this->taskId;
    }

    public function addTaskId(Task $taskId): self
    {
        if (!$this->taskId->contains($taskId)) {
            $this->taskId[] = $taskId;
            $taskId->setTodoList($this);
        }

        return $this;
    }

    public function removeTaskId(Task $taskId): self
    {
        if ($this->taskId->removeElement($taskId)) {
            // set the owning side to null (unless already changed)
            if ($taskId->getTodoList() === $this) {
                $taskId->setTodoList(null);
            }
        }

        return $this;
    }
}
