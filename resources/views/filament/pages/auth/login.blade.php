<x-filament-panels::page.simple>
    <div class="erp-login">

        {{-- LEFT SIDE --}}
        <div class="erp-login__visual">

            <div class="erp-login__overlay"></div>

            <div class="erp-login__content">

                <div class="erp-login__logo">
                    KH
                </div>

                <div>
                    <h1>Kisimani House System</h1>

                    <p>
                        Smart Property Management, Simplified.
                    </p>
                </div>

                <div class="erp-login__features">

                    <div>
                        <span>✓</span>
                        Estate Management
                    </div>

                    <div>
                        <span>✓</span>
                        House &amp; Unit Management
                    </div>

                    <div>
                        <span>✓</span>
                        Tenant Management
                    </div>

                    <div>
                        <span>✓</span>
                        Maintenance &amp; Security
                    </div>

                </div>

            </div>

        </div>


        {{-- RIGHT SIDE --}}
        <div class="erp-login__form">

            <div class="erp-login__form-inner">

                <div class="erp-mobile-logo">
                    KH
                </div>

                <h2>
                    Welcome back
                </h2>

                <p class="erp-login__subtitle">
                    Sign in to your Kisimani House System account.
                </p>

                <div class="erp-login__filament-form">
                    {{ $this->form }}
                </div>

                <div class="erp-login__footer">
                    <span>© {{ date('Y') }} Kisimani House System</span>
                    <span>Secure ERP Portal</span>
                </div>

            </div>

        </div>

    </div>

    <style>
        .erp-login {
            min-height: 100vh;
            width: 100%;
            display: grid;
            grid-template-columns: 58% 42%;
            overflow: hidden;
            background: #f8fafc;
        }

        .erp-login__visual {
            position: relative;
            min-height: 100vh;

            background-image:
                url('/images/login.jpeg');

            background-size: cover;
            background-position: center;

            display: flex;
            align-items: flex-end;
            padding: 60px;
            color: white;
        }

        .erp-login__overlay {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    135deg,
                    rgba(15, 23, 42, 0.92) 0%,
                    rgba(15, 23, 42, 0.65) 45%,
                    rgba(15, 23, 42, 0.30) 100%
                );
        }

        .erp-login__content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        .erp-login__logo,
        .erp-mobile-logo {
            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 16px;

            background: rgba(255, 255, 255, 0.15);

            border: 1px solid rgba(255, 255, 255, 0.25);

            backdrop-filter: blur(15px);

            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .erp-login__content h1 {
            margin-top: 28px;
            margin-bottom: 10px;

            font-size: 42px;
            line-height: 1.1;

            font-weight: 800;
            letter-spacing: -1px;
        }

        .erp-login__content p {
            margin: 0;

            font-size: 18px;
            color: rgba(255, 255, 255, 0.78);
        }

        /*
        |--------------------------------------------------------------------------
        | FEATURES
        |--------------------------------------------------------------------------
        */

        .erp-login__features {
            display: grid;
            grid-template-columns: 1fr 1fr;

            gap: 14px;

            margin-top: 42px;
        }

        .erp-login__features div {
            display: flex;
            align-items: center;
            gap: 10px;

            font-size: 14px;

            color: rgba(255, 255, 255, 0.85);
        }

        .erp-login__features span {
            width: 24px;
            height: 24px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.15);

            font-size: 12px;
        }

        /*
        |--------------------------------------------------------------------------
        | RIGHT SIDE
        |--------------------------------------------------------------------------
        */

        .erp-login__form {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 50px;
        }

        .erp-login__form-inner {
            width: 100%;
            max-width: 430px;
        }

        .erp-login__form h2 {
            margin-top: 28px;
            margin-bottom: 8px;

            font-size: 32px;
            font-weight: 800;

            color: #0f172a;
            letter-spacing: -0.8px;
        }

        .erp-login__subtitle {
            margin-bottom: 32px;

            color: #64748b;
            font-size: 15px;
        }

        .erp-login__filament-form {
            width: 100%;
        }

        .erp-login__footer {
            display: flex;
            justify-content: space-between;

            margin-top: 35px;

            padding-top: 20px;

            border-top: 1px solid #e2e8f0;

            color: #94a3b8;

            font-size: 12px;
        }

        .erp-mobile-logo {
            display: none;

            color: white;
            background: #7c3aed;
        }

        @media (max-width: 900px) {

            .erp-login {
                grid-template-columns: 1fr;
            }

            .erp-login__visual {
                min-height: 300px;

                padding: 40px;
            }

            .erp-login__content h1 {
                font-size: 32px;
            }

            .erp-login__features {
                display: none;
            }

            .erp-login__form {
                min-height: auto;

                padding: 45px 30px;
            }

        }

        @media (max-width: 600px) {

            .erp-login__visual {
                display: none;
            }

            .erp-login__form {
                min-height: 100vh;

                padding: 30px 22px;
            }

            .erp-mobile-logo {
                display: flex;
            }

            .erp-login__form h2 {
                font-size: 28px;
            }

            .erp-login__footer {
                flex-direction: column;
                gap: 6px;
            }
        }
    </style>
</x-filament-panels::page.simple>