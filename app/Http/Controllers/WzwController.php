<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class WzwController extends Controller
{
    public function addTeilnehmer(Group $group)
    {
        $allMembers = json_decode($group->members, true);

        return view('group.addTn', compact('group', 'allMembers'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function showTeilnehmer(Group $group)
    {
        $tv = json_decode($group->members, true);
        $allMembers = json_decode($group->members, true);
        $paid = json_decode($group->expenditures, true);


        for ($i = 0; $i < 40; $i++)
        {
            foreach ($tv as $key => $row) {
                $mussZahlen[$key] = $row['mussZahlen'];
            }

            $mussZahlen = array_column($tv, 'mussZahlen');
            array_multisort($mussZahlen, SORT_DESC, $tv);

            $firstElement  = reset($tv);
            $lastElement = end($tv);

            $division = $firstElement['mussZahlen'] + $lastElement['mussZahlen'];

            if ($division > 0)
            {
                array_pop($tv);
                $tv[0]['mussZahlen'] = $division;
                $amount = $lastElement['mussZahlen'] * -1;
                $wzw[] = "{$lastElement['tn_name']} zahlt $amount € an {$firstElement['tn_name']}";
            }
            else
            {
                $tv[count($tv)-1]['mussZahlen'] = $division;
                unset($tv[0]);
                $wzw[] = "{$lastElement['tn_name']} zahlt {$firstElement['mussZahlen']} € an {$firstElement['tn_name']}";
            }

            if (count($tv) == 1)
                break;
        }


        return view('group.show', compact(
            'group',
            'paid',
            'allMembers',
            'wzw'
        ));
    }


    public function updateTeilnehmer(Request $request, Group $group)
    {
        $this->validate($request, [
            'title'        => 'required|max:255',
        ]);

        $tv = json_decode($group->members, true);

        $zv = json_decode($group->expenditures, true);

        $last_item    = end($tv);
        $tn_id = $last_item['id'];
        $appendtv = array(
            'id' => ++$tn_id,
            'tn_name' => $request->input('tn_name'),
            'mussZahlen' => 0
        );
        array_push($tv, $appendtv);



        $group->title = request('title');
        $group->members = json_encode($tv);
        $group->expenditures = json_encode($zv);

        $group->save();

        return redirect()->action('WzwController@showTeilnehmer', [$group]);
    }


    public function addZahlung(Group $group)
    {
        $allMembers = json_decode($group->members, true);

        return view('group.add', compact('group', 'allMembers'));
    }


    public function updateZahlung(Request $request, Group $group)
    {
        $this->validate($request, [
            'title'        => 'required|max:255',
        ]);

        $tv = json_decode($group->members, true);

        $zv = json_decode($group->expenditures, true);

        $last_item    = end($zv);
        $tn_id = $last_item['id'];
        $append = array(
            'id' => ++$tn_id,
            'wer' => $request->input('wer'),
            'beteiligte' => $request->input('beteiligte'),
            'was' => $request->input('was'),
            'preis' => $request->input('preis')
        );
        array_push($zv, $append);

        $involved = $request->input('beteiligte');

        foreach ($tv as $key => $entry) {
            $average = ($request->input('preis') / count($involved)) * - 1;
            $roundup = round($average, 2);
            $stoploop = 0;

            foreach ($involved as $inv)
            {
                if ($inv == $request->input('wer'))
                {
                    if($tv[$key]['tn_name'] == $request->input('wer'))
                    {
                        $tv[$key]['mussZahlen'] = $tv[$key]['mussZahlen'] + $request->input('preis') + $roundup;
                    }
                }
                else
                {
                    if($tv[$key]['tn_name'] !== $request->input('wer') && $tv[$key]['tn_name'] == $inv && $stoploop < 1)
                    {
                        $tv[$key]['mussZahlen'] = $tv[$key]['mussZahlen'] + $roundup;
                        $stoploop++;
                    }
                }
            }
        }

        $group->title = request('title');
        $group->members = json_encode($tv);
        $group->expenditures = json_encode($zv);

        $group->save();

        return redirect()->action('WzwController@showTeilnehmer', [$group]);
    }


    public function endAbrechnung(Group $group)
    {
        $tv = json_decode($group->members, true);

        for ($i = 0; $i < 40; $i++)
        {
            foreach ($tv as $key => $row) {
                $mussZahlen[$key] = $row['mussZahlen'];
            }

            $mussZahlen = array_column($tv, 'mussZahlen');
            array_multisort($mussZahlen, SORT_DESC, $tv);

            $firstElement  = reset($tv);
            $lastElement = end($tv);

            $division = $firstElement['mussZahlen'] + $lastElement['mussZahlen'];

            if ($division > 0)
            {
                array_pop($tv);
                $tv[0]['mussZahlen'] = $division;
                $amount = $lastElement['mussZahlen'] * -1;
                $wzw[] = "{$lastElement['tn_name']} zahlt $amount € an {$firstElement['tn_name']}";
            }
            else
            {
                $tv[count($tv)-1]['mussZahlen'] = $division;
                unset($tv[0]);
                $wzw[] = "{$lastElement['tn_name']} zahlt {$firstElement['mussZahlen']} € an {$firstElement['tn_name']}";
            }

            if (count($tv) == 1)
                break;
        }

        return view('group.berechnen', compact('group', 'wzw'));
    }
}
