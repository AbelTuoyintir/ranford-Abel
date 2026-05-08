<?php

namespace App\Http\Controllers;

use App\Models\IpAddress;
use Illuminate\Http\Request;

class IpAddressController extends Controller
{
    public function index()
    {
        $ipAddresses = IpAddress::all();
        $activeCount = IpAddress::where('active', true)->count();
        return view('livewire.admin.ipblocker', compact('ipAddresses','activeCount'));
    }

    // Add a new IP address
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|ip',
            'label' => 'required|string|max:255',
        ]);

        IpAddress::create([
            'address' => $request->address,
            'label' => $request->label,
            'active' => false,
            'date_added' => now(),
            'last_active' => now(),
        ]);

        return redirect()->back()->with('success', 'IP address added successfully.');
    }

    // Show the edit form for an IP address
    public function edit($id)
    {
        // Find the IP address by ID
        $ipAddress = IpAddress::findOrFail($id);

        // Return the view with the IP address data
        return view('ip-addresses.edit', compact('ipAddress'));
    }

    // Update an IP address
    public function update(Request $request, IpAddress $ipAddress)
    {
        $request->validate([
            'address' => 'required|ip',
            'label' => 'required|string|max:255',
        ]);

        $ipAddress->update([
            'address' => $request->address,
            'label' => $request->label,
        ]);

        return redirect()->back()->with('success', 'IP address updated successfully.');
    }

    // Delete an IP address
    public function destroy(IpAddress $ipAddress)
    {
        $ipAddress->delete();
        return redirect()->back()->with('success', 'IP address deleted successfully.');
    }

    // Toggle the active status of an IP address
    public function toggleActive(IpAddress $ipAddress)
    {
        $ipAddress->update([
            'active' => !$ipAddress->active,
        ]);

        return redirect()->back()->with('success', 'IP address status toggled successfully.');
    }

}
