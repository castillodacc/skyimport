<?php

namespace skyimport\Http\Controllers;

use Illuminate\Http\Request;
use skyimport\Models\Consolidated;
use skyimport\Models\EventsUsers;

class NotificationController extends Controller
{
	public function notifications(Request $request)
	{
		if (\Auth::user()->role_id == 1) {
			$hoy = \Carbon::now()->format('Y-m-d');
			$num_cons_forma = Consolidated::where('closed_at', 'LIKE', '%'.$hoy.'%')->count();
			$num_cons_forma = $num_cons_forma . ' Consolidados formalizados hoy.';

			$notifications = EventsUsers::where('tracking_id', '=', null)->limit(15)->get();
			$notifications_total = EventsUsers::where('viewed', '=', 0)->where('tracking_id', '=', null)->limit(15)->count();
		} else {
			$num_cons_forma = Consolidated::where('user_id', '=', \Auth::user()->id)->where('closed_at', '>', \Carbon::now())->count();
			$num_cons_forma = $num_cons_forma . ' Consolidados Abiertos.';
		}

		$html = "<li class='header'>$num_cons_forma</li>";
		foreach ($notifications as $notification) {
			$consolidated = $notification->consolidated->number;
			$hace = $notification->created_at->diffForHumans();
			$event = $notification->events->description;
			$html .= "<li>
              <ul class='menu'>
                <li id='notification' consolidated='$notification->id'>
                  <a href='#'>
                    <h4>
                      <i class='fa fa-cube text-primary'></i>
                      $consolidated
                      <small><i class='fa fa-clock-o'></i> $hace</small>
                    </h4>
                    <p>$event</p>
                  </a>
                </li>
              </ul>
            </li>";
		}
		$html .= "<li class='footer'><a href='/consolidados'>Ver todos</a></li>
					</ul>";

		return response()->json(compact('html', 'notifications_total'));
	}

	public function viewer()
	{
		if (\Auth::user()->role_id == 1) {
			$events = EventsUsers::limit(15)->where('tracking_id', '=', null)->get();
			$events->each(function ($event) {
				return $event->update(['viewed' => '1']);
			});
		} else {
			
		}
	}

	public function destroy($id)
	{
        $event = EventsUsers::findOrFail($id)->delete();
        return response()->json($event);
	}
}
