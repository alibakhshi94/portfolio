<?php

namespace Application\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Application\PortfolioBundle\Form\ProjectForm;
use Application\PortfolioBundle\Entity\Project;

/**
 * ProjectController
 */
class ProjectController extends Controller
{

    /**
     * Projects list
     *
     * @return array
     * @extra:Template()
     */
    public function indexAction()
    {
        $projects = $this->get('doctrine')->getEntityManager()
                ->getRepository("PortfolioBundle:Project")->getAllProjects();

        return array('projects' => $projects);
    }

    /**
     * Create new project
     *
     * @return array|RedirectResponse
     * @extra:Template()
     */
    public function createAction()
    {
        $project = new Project();
        $form = $this->get('form.factory')->create(new ProjectForm(), $project);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {
                // create project
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($project);
                $em->flush();

                $this->get('request')->getSession()->setFlash('notice',
                        'Congratulations, your project "' . $project->getName()
                        . '" is successfully created!');

                // redirect to list of projects
                return new RedirectResponse($this->generateUrl('portfolioProjectIndex'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * Edit project
     *
     * @param string $slug
     * @return array|RedirectResponse
     * @extra:Template()
     */
    public function editAction($slug)
    {
        $project = $this->_findProjectBySlug($slug);
        
        $form = $this->get('form.factory')->create(new ProjectForm(), $project);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {
                // save project
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($project);
                $em->flush();

                $this->get('request')->getSession()->setFlash('notice',
                        'Congratulations, your project is successfully updated!');
                return new RedirectResponse($this->generateUrl('portfolioProjectIndex'));
            }
        }

        return array('form' => $form->createView(), 'project' => $project);
    }

    /**
     * View project
     *
     * @param string $categorySlug
     * @param string $projectSlug
     * @return array
     * @extra:Template()
     */
    public function viewAction($categorySlug, $projectSlug)
    {
        // try find project by slug
        $project = $this->_findProjectBySlug($projectSlug);

        // @todo: rm categorySlug from url. add it as param
        // try find category by slug
        $em = $this->get('doctrine')->getEntityManager();
        $category = $em->getRepository("PortfolioBundle:Category")
                ->findOneBy(array('slug' => $categorySlug));

        if (!$category) {
            throw new NotFoundHttpException('The category does not exist.');
        }

        $breadcrumbs = $this->get('menu.breadcrumbs');
        $breadcrumbs->addChild(
                $category->getName(),
                $this->get('router')->generate('portfolioCategoryView', array('slug' => $category->getSlug())));
        $breadcrumbs->addChild($project->getName())->setIsCurrent(true);

        return array('project' => $project, 'category' => $category);
    }

    /**
     * Display links to prev/next projects
     *
     * @param Category $category
     * @param Project $project
     * @return array
     * @extra:Template()
     */
    public function nearbyProjectsAction($category, $project)
    {
        $em = $this->get('doctrine')->getEntityManager();

        // get all projects from this category
        $projects = $em->getRepository("PortfolioBundle:Project")
                ->getProjectsByCategory($category);

        // get next and previous projects from this category
        $i = 0; $previousProject = null; $nextProject = null;
        foreach ($projects as $p) {
            if ($project->getId() == $p->getId()) {
                $previousProject = isset($projects[$i-1]) ? $projects[$i-1] : null;
                $nextProject     = isset($projects[$i+1]) ? $projects[$i+1] : null;
                break;
            }
            $i++;
        }

        return array('category' => $category, 'previousProject' => $previousProject, 'nextProject' => $nextProject);
    }

    /**
     * Delete project
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function deleteAction($slug)
    {
        $project = $this->_findProjectBySlug($slug);

        $em = $this->get('doctrine')->getEntityManager();
        $em->remove($project);
        $em->flush();

        $this->get('request')->getSession()->setFlash('notice',
                'Your project "' . $project->getName() . '" is successfully delete.');
        return new RedirectResponse($this->generateUrl('portfolioProjectIndex'));
    }

    /**
     * Try find project by slug
     *
     * @param string $slug
     * @return Project
     */
    private function _findProjectBySlug($slug)
    {
        $em = $this->get('doctrine')->getEntityManager();

        // try find project by slug
        $project = $em->getRepository("PortfolioBundle:Project")
                ->findOneBy(array('slug' => $slug));
        if (!$project) {
            throw new NotFoundHttpException('The project does not exist.');
        }

        return $project;
    }

}
