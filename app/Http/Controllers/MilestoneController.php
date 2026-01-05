<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Milestone;
use App\Models\Baby;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Return milestones for a baby grouped by category. If missing, create default 3 skills per category.
     */
    public function byBaby(\Illuminate\Http\Request $request, $babyId)
    {
        $baby = Baby::where('id', $babyId)->where('user_id', Auth::id())->firstOrFail();
        // Allow optional month range filter (e.g. 0-3,4-6,7-9,10-12)
        $range = $request->query('range', '0-3');

        // defaults per range: each category contains 3 groups with example sub-skills
        $defaultsPerRange = [
            '0-3' => [
                'physical' => [
                    ['group' => 'Motor', 'items' => ['Lifts head', 'Turns head', 'Makes smooth arm/leg movements']],
                    ['group' => 'Sensory', 'items' => ['Responds to loud sounds', 'Stares at faces', 'Follows objects']],
                    ['group' => 'Feeding', 'items' => ['Sucks well', 'Suckles and swallows', 'Begins solids']],
                    ['group' => 'Reflexes', 'items' => ['Grasps reflex present', 'Startle reflex works', 'Rooting reflex present']],
                    ['group' => 'Sleep', 'items' => ['Sleeps 10-12 hours', 'Wakes up easily', 'Has nap routines']],
                ],
                'cognitive' => [
                    ['group' => 'Problem Solving', 'items' => ['Follows moving objects', 'Recognizes faces', 'Explores objects']],
                    ['group' => 'Attention', 'items' => ['Responds to voice', 'Follows simple movement', 'Focuses briefly']],
                    ['group' => 'Language', 'items' => ['Makes cooing sounds', 'Responds to voice', 'Babbles']],
                    ['group' => 'Memory', 'items' => ['Remembers mother', 'Recognizes routines', 'Shows familiar preference']],
                    ['group' => 'Recognition', 'items' => ['Recognizes caregiver’s voice', 'Differentiates familiar vs unfamiliar sounds', 'Shows preference for familiar objects']],
                ],
                'social' => [
                    ['group' => 'Interaction', 'items' => ['Smiles responsively', 'Looks at parent', 'Enjoys playing']],
                    ['group' => 'Emotional', 'items' => ['Shows comfort', 'Cries for needs', 'Expresses pleasure']],
                    ['group' => 'Communication', 'items' => ['Makes eye contact', 'Vocalizes', 'Responds to sound']],
                    ['group' => 'Bonding', 'items' => ['Recognizes caregiver', 'Seeks comfort from parent', 'Shows preference for familiar faces']],
                    ['group' => 'Awareness', 'items' => ['Responds to caregiver’s presence', 'Shows alertness to voices', 'Looks toward familiar sounds']],
                ],
            ],
            '4-6' => [
                'physical' => [
                    ['group' => 'Motor', 'items' => ['Rolls over', 'Sits with support', 'Reaches for toys']],
                    ['group' => 'Sensory', 'items' => ['Responds to sounds', 'Explores with mouth', 'Tracks objects']],
                    ['group' => 'Fine Motor', 'items' => ['Grasps objects', 'Transfers objects', 'Rakes to pick up']],
                    ['group' => 'Coordination', 'items' => ['Uses both hands together', 'Brings hand to mouth', 'Reaches with coordination']],
                    ['group' => 'Posture', 'items' => ['Holds head steady', 'Sits briefly with support', 'Rolls both ways']],
                ],
                'cognitive' => [
                    ['group' => 'Problem Solving', 'items' => ['Finds partially hidden objects', 'Transfers objects hand to hand', 'Explores cause/effect']],
                    ['group' => 'Attention', 'items' => ['Looks for dropped toys', 'Focuses longer', 'Recognizes routines']],
                    ['group' => 'Language', 'items' => ['Babbles with intent', 'Makes varied sounds', 'Responds to name']],
                    ['group' => 'Learning', 'items' => ['Learns cause and effect', 'Recognizes patterns', 'Anticipates familiar events']],
                    ['group' => 'Exploration', 'items' => ['Examines toys closely', 'Touches different textures', 'Experiments with actions']],
                ],
                'social' => [
                    ['group' => 'Interaction', 'items' => ['Laughs', 'Enjoys games', 'Shows interest in others']],
                    ['group' => 'Emotional', 'items' => ['Expresses joy', 'Shows distress', 'Seeks comfort']],
                    ['group' => 'Communication', 'items' => ['Responds to name', 'Imitates sounds', 'Uses gestures']],
                    ['group' => 'Social Play', 'items' => ['Engages with caregiver', 'Shows excitement', 'Participates in games']],
                    ['group' => 'Attachment', 'items' => ['Shows preference for caregiver', 'Seeks comfort when upset', 'Smiles more at familiar people']],
                ],
            ],
            '7-9' => [
                'physical' => [
                    ['group' => 'Motor', 'items' => ['Sits without support', 'Crawls', 'Pulls to stand']],
                    ['group' => 'Sensory', 'items' => ['Responds to name', 'Looks for hidden things', 'Understands no']],
                    ['group' => 'Mobility', 'items' => ['Stands holding on', 'Cruises', 'Walks with help']],
                    ['group' => 'Balance', 'items' => ['Maintains balance while crawling', 'Sits steadily', 'Stands with minimal support']],
                    ['group' => 'Strength', 'items' => ['Pushes up on arms', 'Supports weight on legs', 'Pulls to stand longer']],
                ],
                'cognitive' => [
                    ['group' => 'Problem Solving', 'items' => ['Finds hidden objects', 'Looks at correct picture when named', 'Explores toys']],
                    ['group' => 'Attention', 'items' => ['Follows simple instructions', 'Shows curiosity', 'Looks at pictures']],
                    ['group' => 'Language', 'items' => ['Babbles with intonation', 'Responds to simple words', 'Repeats sounds']],
                    ['group' => 'Understanding', 'items' => ['Understands simple words', 'Recognizes object names', 'Responds to familiar sounds']],
                    ['group' => 'Imitation', 'items' => ['Copies simple actions', 'Repeats sounds', 'Mimics gestures']],
                ],
                'social' => [
                    ['group' => 'Interaction', 'items' => ['Waves bye', 'Plays peek-a-boo', 'Enjoys social play']],
                    ['group' => 'Emotional', 'items' => ['Shows preferences', 'Has separation awareness', 'Expresses frustration']],
                    ['group' => 'Communication', 'items' => ['Uses gestures', 'Responds to social cues', 'Vocalizes']],
                    ['group' => 'Stranger Awareness', 'items' => ['Shows caution with strangers', 'Prefers familiar people', 'Expresses stranger anxiety']],
                    ['group' => 'Playfulness', 'items' => ['Initiates peek-a-boo', 'Laughs during play', 'Engages in interactive games']],
                ],
            ],
            '10-12' => [
                'physical' => [
                    ['group' => 'Motor', 'items' => ['Stands alone', 'Walks with assistance', 'Picks up small objects']],
                    ['group' => 'Sensory', 'items' => ['Points to objects', 'Imitates gestures', 'Understands simple instructions']],
                    ['group' => 'Self-help', 'items' => ['Drinks from cup', 'Feeds self', 'Holds spoon']],
                    ['group' => 'Dexterity', 'items' => ['Uses pincer grasp', 'Turns pages', 'Claps hands together']],
                    ['group' => 'Coordination', 'items' => ['Stacks objects', 'Places toys deliberately', 'Coordinates hand-eye movements']],
                ],
                'cognitive' => [
                    ['group' => 'Problem Solving', 'items' => ['Looks for things you hide', 'Uses objects correctly', 'Follows simple directions']],
                    ['group' => 'Attention', 'items' => ['Completes simple tasks', 'Notices changes', 'Explores more']],
                    ['group' => 'Language', 'items' => ['Says simple words', 'Imitates speech', 'Responds to requests']],
                    ['group' => 'Knowledge', 'items' => ['Names common objects', 'Points to body parts', 'Understands "yes" and "no"']],
                    ['group' => 'Problem Solving II', 'items' => ['Tries multiple solutions', 'Stacks blocks purposefully', 'Uses tools like spoon or cup']],
                ],
                'social' => [
                    ['group' => 'Interaction', 'items' => ['Shows affection', 'May be shy with strangers', 'Repeats sounds/actions']],
                    ['group' => 'Emotional', 'items' => ['Expresses empathy', 'Shows frustration', 'Seeks attention']],
                    ['group' => 'Communication', 'items' => ['Uses simple words', 'Gestures to communicate', 'Copies sounds']],
                    ['group' => 'Independence', 'items' => ['Asserts independence', 'Shows likes/dislikes', 'Waves goodbye']],
                    ['group' => 'Cooperation', 'items' => ['Helps with dressing', 'Hands objects to caregiver', 'Participates in shared tasks']],
                ],
            ],
        ];

        $defaults = $defaultsPerRange[$range] ?? $defaultsPerRange['0-3'];

        // Get existing milestones for this baby in requested range
        $existing = $baby->milestones()->where('range', $range)->get();

        // Ensure defaults exist for the requested range only: create missing sub-skills as individual milestone records grouped by 'group'
        foreach (['physical', 'cognitive', 'social'] as $cat) {
            foreach ($defaults[$cat] as $grp) {
                foreach ($grp['items'] as $sub) {
                    $exists = $existing->first(function ($m) use ($cat, $grp, $sub, $range) {
                        return ($m->category === $cat) && ($m->group === $grp['group']) && ($m->title === $sub) && ($m->range === $range);
                    });
                    if (!$exists) {
                        Milestone::create([
                            'baby_id' => $baby->id,
                            'title' => $sub,
                            'description' => null,
                            'category' => $cat,
                            'group' => $grp['group'],
                            'range' => $range,
                            'achievedDate' => null,
                        ]);
                    }
                }
            }
        }

        // Refresh collection after any creations (only for this range)
        $milestones = $baby->milestones()->where('range', $range)->get()->groupBy('category');

        $response = [];
        foreach (['physical', 'cognitive', 'social'] as $cat) {
            $catMilestones = $milestones->get($cat, collect());
            // restrict to groups defined in this range to avoid returning unrelated groups
            $allowedGroupNames = collect($defaults[$cat])->pluck('group')->toArray();
            $catMilestones = $catMilestones->filter(function ($m) use ($allowedGroupNames) {
                return in_array($m->group, $allowedGroupNames);
            });

            // group by group field
            $groups = $catMilestones->groupBy('group')->map(function ($groupMilestones, $groupName) {
                $items = $groupMilestones->map(function ($m) {
                    return [
                        'id' => $m->milestoneID,
                        'title' => $m->title,
                        'achieved' => $m->achievedDate ? true : false,
                        'achievedDate' => $m->achievedDate ? Carbon::parse($m->achievedDate)->toDateString() : null,
                    ];
                })->values();

                $total = $items->count();
                $achieved = $items->where('achieved', true)->count();

                // generate a slug for the group and include an image URL if present in public/img/skills
                $slug = Str::slug($groupName);
                $jpgPath = public_path("img/skills/{$slug}.jpg");
                $imageUrl = file_exists($jpgPath) ? asset("img/skills/{$slug}.jpg") : null;

                return [
                    'groupTitle' => $groupName,
                    'slug' => $slug,
                    'image' => $imageUrl,
                    'items' => $items,
                    'total' => $total,
                    'achieved' => $achieved,
                    'percentage' => $total > 0 ? round(100 * $achieved / $total) : 0,
                ];
            })->values();

            // aggregate for category
            $catTotal = $groups->sum('total');
            $catAchieved = $groups->sum('achieved');
            $catPercentage = $catTotal > 0 ? round(100 * $catAchieved / $catTotal) : 0;

            $response[$cat] = [
                'groups' => $groups,
                'total' => $catTotal,
                'achieved' => $catAchieved,
                'percentage' => $catPercentage,
            ];
        }

        return response()->json($response);
    }

    /**
     * Toggle or set milestone achieved with date. Expects JSON { achieved: true|false, achievedDate?: 'YYYY-MM-DD' }
     */
    public function toggle(Request $request, $id)
    {
        $milestone = Milestone::findOrFail($id);
        // Ensure owner
        if ($milestone->baby->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $achieved = $request->input('achieved');
        $date = $request->input('achievedDate');

        if ($achieved) {
            $milestone->achievedDate = $date ? Carbon::parse($date)->toDateString() : Carbon::now()->toDateString();
        } else {
            $milestone->achievedDate = null;
        }

        $milestone->save();

        return response()->json([
            'id' => $milestone->milestoneID,
            'achieved' => $milestone->achievedDate ? true : false,
            'achievedDate' => $milestone->achievedDate,
        ]);
    }

    /**
     * Return recent achieved milestones for a baby (flat list), ordered by achievedDate desc.
     */
    public function recent($babyId)
    {
        $baby = Baby::where('id', $babyId)->where('user_id', Auth::id())->firstOrFail();

        $items = Milestone::where('baby_id', $baby->id)
            ->whereNotNull('achievedDate')
            ->orderBy('achievedDate', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->milestoneID,
                    'title' => $m->title,
                    'achievedDate' => $m->achievedDate ? Carbon::parse($m->achievedDate)->format('F j, Y') : null,
                    'category' => $m->category,
                    'group' => $m->group,
                ];
            });

        return response()->json(['recent' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
