<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();

        return response()->json([
            'groups'    => $groups,
        ], 200);
    }

    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'        => 'required|max:25|unique:groups',
        ]);

        $group = Group::create([
            'title'             => $request->input('title'),
            'user_id'           => auth()->user()->id,
            'members'           => json_encode(array()),
            'expenditures'      => json_encode(array())
        ]);

        return response()->json([
            'group'    => $group,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified group.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $group->members = json_decode($group->members, true);
        $group->expenditures = json_decode($group->expenditures, true);

        return response()->json([
            'group'    => $group,
        ], 200);
    }

    /**
     * Update the specified group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $this->validate($request, [
            'title'        => 'required|max:25',
            'tn_name'      => 'unique:groups,members'
        ]);

        $tv = json_decode($group->members, true);

        if ($request->has('members')) {
            $last_item    = end($tv);
            $tn_id = $last_item['id'];
            $appendtv = array(
                'id' => ++$tn_id,
                'tn_name' => $request->input('members'),
                'mussZahlen' => 0
            );
            array_push($tv, $appendtv);
        }

        $zv = json_decode($group->expenditures, true);
        if ($request->has('expenditures')) {
            $last_item    = end($zv);
            $tn_id = $last_item['id'];
            $append = array(
                'id' => ++$tn_id,
                'wer' => $request->input('expenditures'),
                'was' => $request->input('was'),
                'preis' => $request->input('preis')
            );
            array_push($zv, $append);

            foreach ($tv as $key => $entry) {
                $average = ($request->input('preis') / count($tv)) * - 1;
                if($tv[$key]['tn_name'] == $request->input('expenditures'))
                    $tv[$key]['mussZahlen'] = $tv[$key]['mussZahlen'] + $request->input('preis') + $average;
                else
                    $tv[$key]['mussZahlen'] = $tv[$key]['mussZahlen'] + $average;
            }
        }

        $group->title = request('title');
        $group->members = json_encode($tv);
        $group->expenditures = json_encode($zv);

        $group->save();

        return response()->json([
            'message' => 'Das Update war erfolgreich!'
        ], 200);
    }


    public function calculateWzw(Group $group)
    {
        $tv = json_decode($group->members, true);

        for ($i = 0; $i < 40; $i++) {
            foreach ($tv as $key => $row) {
                $mussZahlen[$key] = $row['mussZahlen'];
            }

            $mussZahlen = array_column($tv, 'mussZahlen');
            array_multisort($mussZahlen, SORT_DESC, $tv);

            $firstElement  = reset($tv);
            $lastElement = end($tv);

            $division = $firstElement['mussZahlen'] + $lastElement['mussZahlen'];

            if ($division > 0) {
                array_pop($tv);
                $tv[0]['mussZahlen'] = $division;
                $amount = $lastElement['mussZahlen'] * -1;
                $wzw[] = "{$lastElement['tn_name']} muss $amount € an {$firstElement['tn_name']} zahlen";
            } else {
                $tv[count($tv)-1]['mussZahlen'] = $division;
                unset($tv[0]);
                $wzw[] = "{$lastElement['tn_name']} muss {$firstElement['mussZahlen']} € an {$firstElement['tn_name']} zahlen";
            }

            if (count($tv) == 1)
                break;
        }

        return response()->json([
            'wzw'    => $wzw,
        ], 200);
    }


    /**
     * Remove the specified group from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json([
            'message' => 'Die Gruppe wurde erfolgreich gelöscht!'
        ], 200);
    }

}
