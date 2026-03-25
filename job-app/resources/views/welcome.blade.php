<x-main-layout title="3ayenni -Find Your Dream Job">
<div  x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" >
    <div class="inline-flex items-center" x-clock x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <h5 class="text-5xl md:text-4xl font-bold mb-6 rounded-full bg-gradient-to-r from-pink-700 to-violet-900 text-white p-4">3ayenni</h5>
</div>
</div>        
     <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" >
    <div x-clock x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <span class="text-5xl md:text-8xl font-serif mb-6 italic">Find Your </span><br>
         <span class="text-5xl md:text-9xl font-serif mb-6 italic text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">Dream Job</span>
</div>
</div> 
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" >
    <div x-clock x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <span class="text-xl md:text-2xl font-serif mb-6 italic">connect with top employers, and find exciting opportunities</span><br>
</div>
</div> 
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" >
    <div x-clock x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <a href="{{ route('register') }}" class="inline-block px-6 py-3 mt-6 text-lg font-medium rounded-full bg-gradient-to-r from-pink-500 to-violet-500 text-white hover:from-pink-600 hover:to-violet-600 transition duration-300">Register</a>
        <a href="{{ route('login') }}" class="inline-block px-6 py-3 mt-6 ml-4 text-lg font-medium rounded-full bg-gradient-to-r from-gray-700 to-gray-900 text-white hover:from-gray-800 hover:to-gray-900 transition duration-300">Login</a>
</div>
</div> 
</x-main-layout>