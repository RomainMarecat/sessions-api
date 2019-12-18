<?php

namespace App\Manager\Admin;

use Doctrine\ORM\EntityManager;
use Helper\RegexHelper;
use Monolog\Logger;
use Symfony\Component\Form\FormFactory;

class BookingManager
{
    protected $logger;

    protected $em;

    protected $formFactory;

    protected $regexHelper;

    public function adminCget(array $filters, $orderBy, $limit, $offset)
    {
        $bookings = $this->getEm()->getRepository('App:Booking')->adminCget($filters, $orderBy, $limit, $offset);

        $sports = array();
        $cities = array();
        foreach ($bookings as $booking) {
            foreach ($booking['courses'] as $c => $course) {
                $sports[] = $course['sport'];
            }
            foreach ($booking['courses'] as $c => $course) {
                $cities[] = $course['city'];
            }
        }

        $sports = $this->getEm()->getRepository('App:Sport')->findSportByIds(array_unique($sports));
        $cities = $this->getEm()->getRepository('App:City')->findCitiesByIds(array_unique($cities));

        foreach ($bookings as $b => $booking) {
            foreach ($booking['courses'] as $c => $course) {
                foreach ($sports as $s => $sport) {
                    if (isset($course['sport'])
                        and isset($sport['id'])
                        and isset($sport['translations']['fr']['title'])
                        and $course['sport'] == $sport['id']) {
                        $bookings[$b]['courses'][$c]['sport'] = $sport['translations']['fr']['title'];
                    }
                }
                foreach ($cities as $ci => $city) {
                    if (isset($course['city'])
                        and isset($city['id'])
                        and isset($city['title'])
                        and $course['city'] == $city['id']) {
                        $bookings[$b]['courses'][$c]['city'] = $city['title'];
                    }
                }
            }
        }

        return $bookings;
    }

    /**
     * Gets the value of logger.
     *
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Sets the value of logger.
     *
     * @param mixed $logger the logger
     *
     * @return self
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Gets the value of em.
     *
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * Sets the value of em.
     *
     * @param mixed $em the em
     *
     * @return self
     */
    public function setEm(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     * Gets the value of formFactory.
     *
     * @return mixed
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * Sets the value of formFactory.
     *
     * @param mixed $formFactory the form factory
     *
     * @return self
     */
    public function setFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;

        return $this;
    }

    /**
     * Gets the value of regexHelper.
     *
     * @return mixed
     */
    public function getRegexHelper()
    {
        return $this->regexHelper;
    }

    /**
     * Sets the value of regexHelper.
     *
     * @param mixed $regexHelper the regex helper
     *
     * @return self
     */
    public function setRegexHelper(RegexHelper $regexHelper)
    {
        $this->regexHelper = $regexHelper;

        return $this;
    }
}
