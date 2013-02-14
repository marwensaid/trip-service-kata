<?php

class TripServiceTest extends PHPUnit_Framework_TestCase {

    /**
     * @var TripService
     */
    private $tripService;
    
    /** @var User */
    private $loggedUser, $anotherUser, $someUser;

    protected function setUp() {
        $this->tripService = $this->getMock('TripService', array('getLoggedUser'));
        $this->loggedUser = new User("Fred");
        $this->anotherUser = new User("Lucile");
    }

    /**
     * @expectedException UserNotLoggedInException
     * @test
     * @covers TripService::getTripsByUser
     */
    public function it_throws_an_exception_if_the_user_is_a_guest() {
        $this->tripService->getTripsByUser(new User("Lucile"));
    }
    
    /**
     * @test
     */
    public function it_doesnt_return_trips_if_the_given_user_has_no_friends() {
        $this->tripService->expects($this->any())
                ->method('getLoggedUser')
                ->will($this->returnValue($this->loggedUser));
        $tripsByUser = $this->tripService->getTripsByUser(new User("Lucile"));
        $noTrips = array();
        $this->assertEquals($noTrips, $tripsByUser);
    }
    /**
     * @test
     */
    public function it_doesnt_return_trips_if_loggedUser_and_given_user_are_not_friends() {
        $this->tripService->expects($this->any())
                ->method('getLoggedUser')
                ->will($this->returnValue($this->loggedUser));
        $givenUser = new User("Lucile");
        $givenUser->addFriend($this->anotherUser);
        $tripsByUser = $this->tripService->getTripsByUser($givenUser);
        $noTrips = array();
        $this->assertEquals($noTrips, $tripsByUser);
    }
    
}

