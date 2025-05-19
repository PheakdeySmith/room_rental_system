<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Services\ContractService;
use App\Http\Requests\StoreContractRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContractController extends Controller
{
    use AuthorizesRequests;

    protected $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
        $this->middleware(['auth', 'role:landlord|admin']);
    }

    public function index()
    {
        // Admin sees all contracts, landlords see only their own
        $user = Auth::user();
        if($user && $user->hasRole('admin')) {
            $contracts = Contract::with(['room', 'tenant', 'landlord'])->get();
        } else {
            $contracts = $this->contractService->getAll();
        }

        return view('backends.dashboard.contracts.index', compact('contracts'));
    }

    public function create()
    {
        // Landlords see only their own rooms, admin can see all rooms
        $user = Auth::user();
        if ($user && $user->hasRole('landlord')) {
            $rooms = $user->rooms()->get();
        } else {
            $rooms = Room::all();
        }

        return view('backends.dashboard.contracts.create', compact('rooms'));
    }

    public function store(StoreContractRequest $request)
    {
        $data = $request->validated();  // Validates the input data

        // Admin must specify the landlord, landlords automatically use their own ID
        $user = Auth::user();
        if($user && $user->hasRole('admin')) {
            $data['landlord_id'] = $request->input('landlord_id');
        } else {
            $data['landlord_id'] = $user->id;
        }

        // Create the contract using the service layer
        $this->contractService->create($data);

        return redirect()->route('contracts.index')->with('success', 'Contract created');
    }
}
