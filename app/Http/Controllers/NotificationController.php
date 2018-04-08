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
			$notifications = Consolidated::where('closed_at', 'LIKE', '%'.$hoy.'%')
							->where('shippingstate_id', '=', 3)->get();
			$notifications_total = $notifications->count();

			$html = "<li class='header'>$notifications_total  Consolidados formalizados hoy.</li>";
			foreach ($notifications as $notification) {
				$consolidated = $notification->number;
				$hace = $notification->created_at->diffForHumans();
				$event = $notification->Shippingstate->state;
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
		} else {
			$num_cons_forma = Consolidated::where('user_id', '=', \Auth::user()->id)->where('closed_at', '>', \Carbon::now())->count();
			$num_cons_forma = $num_cons_forma . ' Consolidados Abiertos.';
		}

		return response()->json(compact('html', 'notifications_total'));
	}

	public function viewer()
	{
		// if (\Auth::user()->role_id == 1) {
		// 	$events = EventsUsers::limit(15)->where('tracking_id', '=', null)->get();
		// 	$events->each(function ($event) {
		// 		return $event->update(['viewed' => '1']);
		// 	});
		// } else {
			
		// }
	}

	public function destroy($id)
	{
        $event = EventsUsers::findOrFail($id)->delete();
        return response()->json($event);
	}
}
