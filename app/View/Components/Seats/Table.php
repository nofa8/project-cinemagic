<?php

namespace App\View\Components\Seats;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Database\Eloquent\Collection;

class Table extends Component
{
    public $table = [];
    public $seatMatrix = [];
    private function getTable(Collection $seats, Collection $tickets)
    {
        
        $table = [];
        $seats = $seats->sortBy('row')->sortBy('seat_number')->values();
        foreach ($seats as $seat) {
            $seatMatrix[$seat->row][$seat->seat_number] = $seat->id;
        }
        if ($tickets->count()==0){
            $tickets = new Collection;
        }else{
            $tickets = $tickets->pluck('seat_id');
        }   
        
        
        foreach ($seatMatrix as $seat=>$array) {
            foreach($array as $row=>$id){
                if ($tickets->contains($id)) {
                    
                    $table[$seat][$row] = 'disabled';
                    continue;
                }
            
                $table[$seat][$row] = 'enabled';
        
            }
        }


        return [
            "table"=>$table,
            "matrix"=>$seatMatrix
        ];
    }


    public function __construct(
        public Collection $seats,
        public Collection $tickets= new Collection
    )
    {
        $data = $this->getTable($seats, $tickets);
        $this->table = $data['table'];
        $this->seatMatrix = $data['matrix'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.seats.table');
    }
}
