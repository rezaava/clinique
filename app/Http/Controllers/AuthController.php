<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::user()) {
            if (Auth::user()->hasRole('employee')) {
                return redirect()->route('dashboard.index');
            }
            if (Auth::user()->hasRole('patient')) {
                return redirect()->route('appointments.create');
            }
        }
        return view('auth.login');
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:20|unique:users',
            'email' => 'nullable|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'national_code' => 'nullable|string|size:10|unique:users',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Generate referral code
            $referralCode = $this->generateReferralCode();

            // Get default tier
            $defaultTier = Tier::where('slug', 'normal')->first();

            // Create user
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->national_code = $request->national_code;
            $user->gender = $request->gender;
            $user->birth_date = $request->birth_date;
            $user->referral_code = $referralCode;
            $user->points = 0;
            $user->tier_id = $defaultTier->id ?? null;
            $user->status = 'active';
            $user->save();

            $user->addRole('patient');

            // Login the user
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'ثبت نام با موفقیت انجام شد');

        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ثبت نام: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Attempt to login
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();

            // Check user status
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->with('error', 'حساب کاربری شما غیرفعال است');
            }

            // Update last login
            $user->last_login_at = now();
            $user->save();

            if (Auth::user()->hasRole('employee')) {
                return redirect()->route('dashboard.index')->with('success', 'ورود با موفقیت انجام شد');
            }
        }

        return back()->with('error', 'شماره تلفن یا رمز عبور اشتباه است')->withInput();
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'خروج با موفقیت انجام شد');
    }

    /**
     * Dashboard page
     */
    public function dashboard()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    /**
     * Profile page
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load(['tier', 'roles']);
        return view('profile', compact('user'));
    }

    /**
     * Generate unique referral code
     */
    private function generateReferralCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}