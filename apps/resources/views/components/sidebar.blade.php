<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-gray-800 border-r-0 sm:border-r-2 border-gray-200 dark:border-gray-800 scrollbar-thin scrollbar-thumb-rounded-full scrollbar-thumb-slate-300 scrollbar-track-slate-100 dark:scrollbar-thumb-slate-300 dark:scrollbar-track-slate-500 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
        <div class="h-48 flex items-center">
            <p class="items-center mx-auto text-4xl font-semibold dark:text-white">ATS</p>
        </div>
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ url('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24,19V4c0-1.654-1.346-3-3-3H3C1.346,1,0,2.346,0,4v15H11v2H6v2h12v-2h-5v-2h11ZM16,5h5v2h-5v-2Zm0,4h5v2h-5v-2Zm0,4h5v2h-5v-2Zm-8,2c-2.761,0-5-2.239-5-5,0-2.419,1.718-4.436,4-4.899v5.313l3.754,3.754c-.79,.523-1.736,.832-2.754,.832Zm4.168-2.246l-3.168-3.168V5.101c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Z"/>
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('asset') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Asset</span>
                </a>
            </li>
            <li>
                <a href="{{ url('category') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"  aria-hidden="true" fill="currentColor" >
                        <path d="m0,3v7h10V0H3C1.346,0,0,1.346,0,3Zm22,0c0-1.654-1.346-3-3-3h-7v10h10V3ZM0,19c0,1.654,1.346,3,3,3h7v-10H0v7Zm23.979,3.564l-2.812-2.812c.524-.791.833-1.736.833-2.753,0-2.757-2.243-5-5-5s-5,2.243-5,5,2.243,5,5,5c1.017,0,1.962-.309,2.753-.833l2.812,2.812,1.414-1.414Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Categories</span>
                </a>
            </li>
            <li>
                <a href="{{ url('location') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" >
                        <path d="M12,.042a9.992,9.992,0,0,0-9.981,9.98c0,2.57,1.99,6.592,5.915,11.954a5.034,5.034,0,0,0,8.132,0c3.925-5.362,5.915-9.384,5.915-11.954A9.992,9.992,0,0,0,12,.042ZM12,14a4,4,0,1,1,4-4A4,4,0,0,1,12,14Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Location</span>
                </a>
            </li>
            <li>
                <a href="{{ url('department') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor"  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="m14.5 2.5c0 1.381-1.119 2.5-2.5 2.5s-2.5-1.119-2.5-2.5 1.119-2.5 2.5-2.5 2.5 1.119 2.5 2.5zm1.5 7.5c0-2.206-1.794-4-4-4s-4 1.794-4 4c0 .552.448 1 1 1h6c.552 0 1-.448 1-1zm-13.5-1c1.381 0 2.5-1.119 2.5-2.5s-1.119-2.5-2.5-2.5-2.5 1.119-2.5 2.5 1.119 2.5 2.5 2.5zm2.5 14c0 .552-.448 1-1 1h-3c-.552 0-1-.448-1-1s.448-1 1-1h3c.552 0 1 .448 1 1zm14-16.5c0-1.381 1.119-2.5 2.5-2.5s2.5 1.119 2.5 2.5-1.119 2.5-2.5 2.5-2.5-1.119-2.5-2.5zm-10 14v2.5c0 .552-.448 1-1 1s-1-.448-1-1v-2.5c0-.276-.224-.5-.5-.5 0 0-3.535 0-3.552-.001-1.63-.028-2.948-1.362-2.948-2.999v-4.5c0-1.381 1.119-2.5 2.5-2.5s2.5 1.119 2.5 2.5v5.5h1.5c1.378 0 2.5 1.122 2.5 2.5zm8.5-2.5h1.5v-5.5c0-1.381 1.119-2.5 2.5-2.5s2.5 1.119 2.5 2.5v4.5c0 1.637-1.318 2.971-2.948 2.999-.017 0-3.552.001-3.552.001-.276 0-.5.224-.5.5v2.5c0 .552-.448 1-1 1s-1-.448-1-1v-2.5c0-1.378 1.122-2.5 2.5-2.5zm6.5 5c0 .552-.448 1-1 1h-3c-.552 0-1-.448-1-1s.448-1 1-1h3c.552 0 1 .448 1 1zm-8-8h-8c-.552 0-1-.448-1-1s.448-1 1-1h8c.552 0 1 .448 1 1s-.448 1-1 1z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Departments</span>
                </a>
            </li>
            <li>
                <a href="{{ url('vendor') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor"  viewBox="0 0 24 24">
                        <path d="m19.68,15.667v.333c0,1.105-.831,2-1.857,2h-.619c-1.026,0-1.857-.895-1.857-2v-.333s0,.333,0,.333h0c0,1.105-.831,2-1.857,2h-.619c-.929,0-1.699-.735-1.836-1.694-.028-.199.018-.403.095-.589l.355-.861c.463-1.123,1.558-1.856,2.773-1.856h6.509c1.215,0,2.31.733,2.773,1.856l.355.861c.077.186.124.39.095.589-.137.959-.906,1.694-1.836,1.694h-.619c-1.026,0-1.857-.895-1.857-2h0m-5.68-10c0-3.309-2.691-6-6-6S2,2.691,2,6s2.691,6,6,6,6-2.691,6-6Zm8.156,14h-.619c-.673,0-1.306-.18-1.856-.495-.552.315-1.185.495-1.857.495h-.619c-.673,0-1.306-.18-1.857-.495-.551.315-1.184.495-1.856.495h-.619c-.295,0-.579-.047-.857-.113v1.113c0,1.654,1.346,3,3,3h5c1.654,0,3-1.346,3-3v-1.113c-.278.067-.563.113-.857.113Zm-12.142,1v-2.339c-.495-.568-.845-1.276-.959-2.073-.075-.534,0-1.082.225-1.629l.328-.797c-.52-.106-1.057-.162-1.608-.162C3.589,14,0,17.589,0,22v1c0,.552.447,1,1,1h10.039c-.635-.838-1.026-1.87-1.026-3Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Vendor</span>
                </a>
            </li>
            
            <div class="w-full h-5 border-b-4 border-gray-200 dark:border-gray-700 rounded-md"></div>

            <li>
                <a href="{{ url('audit') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor"   viewBox="0 0 24 24">
                        <path d="m19.414,5h-4.414V.586l4.414,4.414Zm3.148,18.976l-3.089-3.089c-.981.698-2.177,1.113-3.473,1.113-3.314,0-6-2.686-6-6s2.686-6,6-6,6,2.686,6,6c0,1.296-.415,2.492-1.113,3.473l3.089,3.089-1.414,1.414Zm-5.81-5.537l3.607-3.696-1.398-1.43-3.614,3.703-2.216-2.301-1.387,1.441,2.182,2.268c.766.765,2.079.763,2.823.019l.004-.004Zm-8.163.56h-4.589v-2h4.069c-.041-.328-.069-.661-.069-1s.028-.672.069-1h-4.069v-2h4.589c.295-.726.692-1.398,1.176-2h-5.765v-2h8.136c1.147-.636,2.463-1,3.864-1,1.458,0,2.822.398,4,1.082v-2.082h-7V0H3C1.343,0,0,1.343,0,3v21h16c-3.35,0-6.221-2.072-7.411-5Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Audit</span>
                </a>
            </li>
            <li>
                <a href="{{ url('account') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Account</span>
                </a>
            </li>
            <li>
                <a href="{{ url('role') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18,8c-2.206,0-4-1.794-4-4S15.794,0,18,0s4,1.794,4,4-1.794,4-4,4Zm-6,7c-2.206,0-4-1.794-4-4s1.794-4,4-4,4,1.794,4,4-1.794,4-4,4Zm-6-7c-2.206,0-4-1.794-4-4S3.794,0,6,0s4,1.794,4,4-1.794,4-4,4Zm17,14h-5c0-3.309-2.691-6-6-6s-6,2.691-6,6H1c-.553,0-1,.447-1,1s.447,1,1,1H23c.553,0,1-.447,1-1s-.447-1-1-1ZM1,17H5.764c.558-.695,1.23-1.292,1.986-1.769-1.081-1.086-1.75-2.581-1.75-4.231,0-.34,.035-.671,.09-.995-.03,0-.059-.005-.09-.005-3.309,0-6,2.691-6,6,0,.553,.447,1,1,1Zm23-1c0-3.309-2.691-6-6-6-.03,0-.059,.004-.09,.005,.055,.325,.09,.656,.09,.995,0,1.65-.669,3.145-1.75,4.231,.756,.477,1.428,1.074,1.986,1.769h4.764c.553,0,1-.447,1-1Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Roles</span>
                </a>
            </li>
            
            <div class="w-full h-5 border-b-4 border-gray-200 dark:border-gray-700 rounded-md"></div>
            
            <li>
                <a href="{{ url('logout') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>