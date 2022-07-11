<?php

namespace App\Http\Livewire;

use App\Models\Airport;
use App\Models\Flight;
use Livewire\Component;

class SearchFlight extends Component
{
    public $airports;
    public $from;
    public $to;
    public $stopOvers;
    private $maxStopOvers = 2;



    /**
     * @var array|mixed
     */
    public mixed $flight;


    public function mount()
    {
        $this->airports = Airport::get();
        $this->from = $this->airports->first()->code;
        $this->to = $this->airports->last()->code;
        $this->stopOvers = 2;
        $this->findCheaperFlight();
    }

    public function swap()
    {
        $from = $this->from;
        $this->from = $this->to;
        $this->to = $from;
        $this->findCheaperFlight();
    }

    public function decrementStopOvers(){
        if($this->stopOvers > 0){
            $this->stopOvers--;
        }
        $this->findCheaperFlight();
    }

    public function incrementStopOvers(){
        if($this->stopOvers < $this->maxStopOvers){
            $this->stopOvers++;
        }
        $this->findCheaperFlight();
    }

    public function findCheaperFlight(): void
    {

        /* Creating an array of airports and setting the price to the maximum integer value. */
        $flights = Flight::get();

        $options = [];

        foreach ($this->airports as $airport) {
            $options[$airport->code] = [
                'price' => PHP_INT_MAX,
                'connections' => 0,
            ];
        }

        $options[$this->from] = [
            'price' =>  0,
            'connections' => 0,
        ];

        /* Finding the cheapest flight from the source to the destination. */
        for ($i = 0; $i < ($this->stopOvers +1); $i++) {
            $optionsCopy = $options;

            foreach ($flights as $flight) {
                $source = $flight->code_departure;
                $destination = $flight->code_arrival;
                $price = $flight->price;

                /* Checking if the price of the flight is less than the price of the destination. If it is, it sets the
                price of the destination to the price of the flight. */
                if ($options[$source]['price'] + $price < $optionsCopy[$destination]['price']) {
                    $optionsCopy[$destination]['price'] = $options[$source]['price'] + $price;
                    $optionsCopy[$destination]['connections'] = $i;
                }
            }
            $options = $optionsCopy;
        }
        /* Checking if the price is not the maximum integer value, if it is not, it returns the price, if it is, it returns
        null. */
        $this->flight = $options[$this->to]['price'] !== PHP_INT_MAX ?  $options[$this->to] : null;
    }

    public function updated(){
        $this->findCheaperFlight();
    }


    public function render()
    {
        return view('livewire.search-flight');
    }
}
