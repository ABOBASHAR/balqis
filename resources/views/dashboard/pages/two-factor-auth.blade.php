@extends('layouts.dashboard.index')



@section('content')
    <div class="two-factor-page">
        <div class="security-hero mb-4">
            <div class="d-flex align-items-center position-relative" style="z-index: 1;">
                <div class="security-icon ml-3"><i class="fas fa-shield-alt"></i></div>
                <div>
                    <div class="text-white-50 small mb-1">أمان الحساب</div>
                    <h2 class="mb-1 font-weight-bold">التحقق بخطوتين</h2>
                    <p class="mb-0 text-white-50">طبقة حماية إضافية لحسابك عند تسجيل الدخول.</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm" role="alert">
                <strong><i class="fas fa-exclamation-circle ml-1"></i>تعذر تنفيذ العملية</strong>
                <ul class="mb-0 mt-2 pr-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!$user->two_factor_secret)
            <div class="card security-card">
                <div class="card-body p-4 p-md-5 text-center">
                    <div class="text-muted mb-3"><i class="fas fa-mobile-alt fa-3x"></i></div>
                    <h4 class="font-weight-bold">لم يتم تفعيل التحقق بخطوتين</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 560px;">
                        استخدم تطبيق مصادقة مثل Google Authenticator لإنشاء رموز دخول مؤقتة وحماية حسابك من الدخول غير المصرح به.
                    </p>
                    <form action="{{ route('two-factor.enable') }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-lock ml-1"></i> تفعيل الحماية الآن
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="card security-card mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-start justify-content-between flex-wrap mb-4">
                        <div>
                            <span class="badge badge-success px-3 py-2 mb-2"><i class="fas fa-check-circle ml-1"></i>مفعل</span>
                            <h4 class="font-weight-bold mb-1">حسابك محمي</h4>
                            <p class="text-muted mb-0">امسح رمز QR باستخدام تطبيق المصادقة لديك.</p>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-lg-5 text-center mb-4 mb-lg-0">
                            <div class="qr-frame">{!! $user->twoFactorQrCodeSvg() !!}</div>
                            <div class="small text-muted mt-3"><i class="fas fa-camera ml-1"></i> افتح تطبيق المصادقة لمسح الرمز</div>
                        </div>
                        <div class="col-lg-7">
                            <div class="border-right pr-lg-4">
                                <h5 class="font-weight-bold mb-2"><i class="fas fa-key ml-1 text-warning"></i>رموز الاسترداد</h5>
                                <p class="small text-muted mb-3">احتفظ بها في مكان آمن. يمكنك استخدام كل رمز مرة واحدة عند فقدان الوصول إلى تطبيق المصادقة.</p>
                                <div class="row">
                                    @foreach ($user->recoverycodes() as $code)
                                        <div class="col-sm-6 mb-2"><div class="recovery-code">{{ $code }}</div></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <p class="text-muted small mb-3"><i class="fas fa-info-circle ml-1"></i> لا تعطل هذه الميزة إلا إذا كان ذلك ضرورياً.</p>
                <form action="{{ route('two-factor.disable') }}" method="POST" class="mb-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-unlock ml-1"></i> تعطيل التحقق بخطوتين</button>
                </form>
            </div>
        @endif
    </div>
@endsection
@push('styles')
    <style>
        .two-factor-page .security-hero {
            background: linear-gradient(135deg, #3b2415 0%, #6f4328 100%);
            color: #fff;
            border-radius: 14px;
            padding: 28px 32px;
            position: relative;
            overflow: hidden;
        }

        .two-factor-page .security-hero::after {
            content: '\f023';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            left: 28px;
            bottom: -26px;
            color: rgba(255, 255, 255, .08);
            font-size: 150px;
        }

        .two-factor-page .security-icon {
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, .14);
            font-size: 22px;
        }

        .two-factor-page .security-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(74, 49, 32, .08);
        }

        .two-factor-page .qr-frame {
            background: #fff;
            border: 1px solid #eee5dc;
            border-radius: 12px;
            display: inline-flex;
            padding: 14px;
        }

        .two-factor-page .qr-frame svg {
            width: 210px;
            height: 210px;
        }

        .two-factor-page .recovery-code {
            background: #faf8f5;
            border: 1px solid #eee5dc;
            border-radius: 8px;
            color: #553721;
            font-family: monospace;
            font-size: 14px;
            letter-spacing: .04em;
            padding: 10px 12px;
            text-align: center;
        }

        @media (max-width: 767.98px) {
            .two-factor-page .security-hero {
                padding: 22px 20px;
            }

            .two-factor-page .qr-frame svg {
                width: 180px;
                height: 180px;
            }
        }
    </style>
@endpush