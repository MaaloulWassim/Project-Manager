<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Tasks;
use App\Entity\Users;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TasksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,["attr" => [
                "class" => "form-control"
            ]])
            #->add('task_statue', BooleanType::class)
            ->add('tmaker', EntityType::class, ["class" => Users::class,
                "choice_label" => "email",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('project_tasks',EntityType::class,["class" => Project::class,
                "choice_label" => "num_project",
                "attr" => [
                    "class" => "form-control"
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tasks::class,
        ]);
    }
}
