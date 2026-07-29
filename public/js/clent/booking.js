const alerts=[
  {type:'amber',icon:'allergy',t:'هشدار حساسیت',d:'حساسیت به لیدوکائین — تست پوستی قبل از درمان لازم است'},
  {type:'red',icon:'payment',t:'پرداخت معوق',d:'۲۴ میلیون تومان بدهی — فاکتور INV-2891'},
  {type:'blue',icon:'form',t:'فرم رضایت ناقص',d:'فرم رضایت بوتاکس هنوز امضا نشده'},
  {type:'amber',icon:'noshow',t:'سابقه عدم‌حضور',d:'۲ عدم‌حضور در ۶ ماه گذشته — بیعانه لازم است'},
  {type:'gray',icon:'incomplete',t:'درمان ناتمام',d:'دوره لیزر — ۲ از ۶ جلسه انجام شده'},
];
const types=[
  {icon:'consultation',label:'مشاوره'},{icon:'laser',label:'لیزر'},
  {icon:'botox',label:'بوتاکس',active:true},{icon:'filler',label:'فیلر'},
  {icon:'facial',label:'فیشیال'},{icon:'followup',label:'پیگیری'},
];
const doctors=[
  {init:'ج‌م',name:'دکتر جیمز میچل',sub:'جراحی زیبایی',sel:'sel-blue',active:true},
  {init:'ا‌پ',name:'دکتر النا پارک',sub:'پوست',sel:'sel-blue'},
  {init:'س‌ت',name:'دکتر ساموئل تورس',sub:'لیزردرمانی',sel:'sel-blue',busy:true},
];
const rooms=[
  {icon:'pin',name:'سوئیت A',sub:'درمان',sel:'sel-green',active:true},
  {icon:'pin',name:'سوئیت B',sub:'مشاوره',sel:'sel-green'},
  {icon:'pin',name:'اتاق لیزر',sub:'لیزر',sel:'sel-green',busy:true},
];
const devices=[
  {icon:'chip',name:'سینوژر الیت+',sub:'لیزر',sel:'sel-purple',active:true},
  {icon:'chip',name:'ترماژ FLX',sub:'دستگاه RF',sel:'sel-purple'},
  {icon:'chip',name:'هایدرافیشیال MD',sub:'فیشیال',sel:'sel-purple',busy:true},
];
const treatActive=0;
const slots=[
  {t:'۰۹:۰۰',s:'booked'},{t:'۰۹:۳۰',s:'booked'},{t:'۱۰:۰۰',s:'selected'},
  {t:'۱۰:۳۰',s:'free'},{t:'۱۱:۰۰',s:'free'},{t:'۱۱:۳۰',s:'booked'},
  {t:'۱۳:۰۰',s:'free'},{t:'۱۳:۳۰',s:'free'},{t:'۱۴:۰۰',s:'booked'},
  {t:'۱۴:۳۰',s:'free'},{t:'۱۵:۰۰',s:'free'},{t:'۱۵:۳۰',s:'free'},
  {t:'۱۶:۰۰',s:'free'},{t:'۱۶:۳۰',s:'free'},{t:'۱۷:۰۰',s:'free'},
];
// تقویم تیر ۱۴۰۴: روز اول = یکشنبه، ۳۱ روز، روز ۳۱ انتخاب‌شده
const calBusy=[3,9,16,23,30];
const weekHead=['ش','ی','د','س','چ','پ','ج'];
const calFirstDayCol=1; // یکشنبه (ستون دوم، ایندکس ۱)
const calDays=31;

const docSched=[
  {init:'ج‌م',name:'جیمز میچل',blocks:[
    {span:1,type:'booked',label:'ماریا ک. — بوتاکس'},{span:1,type:'free',label:'آزاد'},
    {span:1,type:'sel',label:'سوفیا ا. ★'},{span:1,type:'empty'},
    {span:1,type:'booked',label:'جنیفر ل. — فیلر'},{span:1,type:'free',label:'آزاد'},
    {span:1,type:'empty'},{span:1,type:'booked',label:'پاتریشیا ن. — مشاوره'},
  ]},
  {init:'ا‌پ',name:'النا پارک',blocks:[
    {span:2,type:'free',label:'آزاد'},{span:2,type:'booked',label:'آلیس ب. — لیزر'},
    {span:2,type:'free',label:'آزاد'},{span:2,type:'booked',label:'ساندرا م. — فیشیال'},
  ]},
  {init:'س‌ت',name:'ساموئل تورس',blocks:[
    {span:3,type:'booked',label:'کارلوس ر. — RF'},{span:1,type:'empty'},
    {span:4,type:'booked',label:'کاملاً پُر'},
  ]},
];
const roomSched=[
  {name:'سوئیت A',blocks:[{span:2,type:'free',label:'آزاد'},{span:1,type:'sel',label:'سوفیا ا. ★'},{span:5,type:'free',label:'آزاد'}]},
  {name:'سوئیت B',blocks:[{span:3,type:'booked',label:'ماریا ک.'},{span:5,type:'free',label:'آزاد'}]},
  {name:'اتاق لیزر',blocks:[{span:8,type:'booked',label:'جلسات لیزر — تمام روز'}]},
];
const deviceAvail=[
  {name:'سینوژر الیت+',type:'دستگاه لیزر',status:'available',statusL:'در دسترس',used:'۴٬۲۰۰ / ۵۰٬۰۰۰ شات',pct:8,fill:'green',maint:'۱۹ مرداد ۱۴۰۴'},
  {name:'ترماژ FLX',type:'دستگاه RF',status:'available',statusL:'در دسترس',used:'۱٬۸۲۰ درمان',pct:36,fill:'blue',maint:'۱۲ شهریور ۱۴۰۴'},
  {name:'هایدرافیشیال MD',type:'دستگاه فیشیال',status:'inuse',statusL:'در حال استفاده',used:'۳٬۱۲۰ جلسه',pct:62,fill:'amber',maint:'۶ مرداد ۱۴۰۴'},
];
const recentAppts=[
  {dot:'green',name:'بوتاکس — پیشانی ۲۰ واحد',sub:'۲۸ خرداد ۱۴۰۴ · دکتر میچل',badge:'انجام‌شده',bcls:'li-done'},
  {dot:'green',name:'فیلر لب ۰.۵ میلی‌لیتر',sub:'۱۶ فروردین ۱۴۰۴ · دکتر میچل',badge:'انجام‌شده',bcls:'li-done'},
  {dot:'green',name:'هایدرافیشیال کلاسیک',sub:'۱ اسفند ۱۴۰۳ · دکتر پارک',badge:'انجام‌شده',bcls:'li-done'},
  {dot:'red',name:'مشاوره',sub:'۱۹ دی ۱۴۰۳ · دکتر میچل',badge:'عدم‌حضور',bcls:'li-noshow'},
  {dot:'green',name:'پیلینگ شیمیایی',sub:'۱۳ آبان ۱۴۰۳ · دکتر پارک',badge:'انجام‌شده',bcls:'li-done'},
];
const treatHistory=[
  {name:'بوتاکس ۲۰ واحد',sub:'۶ جلسه · آخرین: ۲۸ خرداد ۱۴۰۴',stars:5},
  {name:'فیلر لب',sub:'۳ جلسه · آخرین: ۱۶ فروردین ۱۴۰۴',stars:5},
  {name:'هایدرافیشیال',sub:'۴ جلسه · آخرین: ۱ اسفند ۱۴۰۳',stars:4},
  {name:'لیزر روسرفیسینگ',sub:'۲ از ۶ · آخرین: ۲۴ آبان ۱۴۰۳',stars:4},
  {name:'پیلینگ شیمیایی',sub:'۲ جلسه · آخرین: ۱۳ آبان ۱۴۰۳',stars:3},
];
const campHistory=[
  {init:'ای',name:'کمپین درخشش تابستان',sub:'۱۱ خرداد ۱۴۰۴',badge:'باز شد',bcls:'cst-opened'},
  {init:'پی',name:'ماه آگاهی بوتاکس',sub:'۲۵ اردیبهشت ۱۴۰۴',badge:'کلیک شد',bcls:'cst-clicked'},
  {init:'ای',name:'رویداد بهاره VIP',sub:'۱۲ فروردین ۱۴۰۴',badge:'حضور یافت',bcls:'cst-attended'},
  {init:'پی',name:'یادآوری دوره لیزر',sub:'۲۷ اسفند ۱۴۰۳',badge:'نادیده',bcls:'cst-ignored'},
  {init:'ز‌ت',name:'پیشنهاد تازگی زمستان',sub:'۲۱ دی ۱۴۰۳',badge:'رزرو شد',bcls:'cst-booked'},
];
const todaySchedule=[
  {time:'۰۹:۰۰',pt:'ماریا کیم',tag:'now',tagL:'اکنون',desc:'بوتاکس · دکتر میچل'},
  {time:'۱۰:۰۰',pt:'سوفیا اندرسن',tag:'new',tagL:'جدید',desc:'بوتاکس (در انتظار) · دکتر ...'},
  {time:'۱۱:۰۰',pt:'جنیفر لوئیس',desc:'فیلر لب · دکتر میچل'},
  {time:'۱۳:۰۰',pt:'آلیس بروکس',desc:'لیزر کل صورت · دکتر پارک'},
  {time:'۱۴:۳۰',pt:'پاتریشیا نوو',desc:'مشاوره · دکتر میچل'},
  {time:'۱۶:۰۰',pt:'ساندرا میلز',desc:'هایدرافیشیال · دکتر پارک'},
];
const weekAhead=[
  {day:'چهارشنبه ۱ مرداد',pct:53,fill:'amber',count:8},
  {day:'پنجشنبه ۲ مرداد',pct:80,fill:'red',count:12},
  {day:'جمعه ۳ مرداد',pct:33,fill:'green',count:5},
];
const quickActions=[
  {icon:'walkin',label:'ثبت مراجعه حضوری'},
  {icon:'emergency',label:'رزرو اورژانسی',emergency:true},
  {icon:'reschedule',label:'زمان‌بندی مجدد'},
  {icon:'cancel',label:'لغو نوبت'},
  {icon:'print',label:'چاپ نوبت'},
  {icon:'consent',label:'ارسال فرم رضایت'},
];

/* رندر */
document.getElementById('nav').innerHTML='<div class="nav-label">منوی اصلی</div>'+navItems.map(i=>`<a href="#" class="nav-item ${i.active?'active':''}" ${i.active?'aria-current="page"':''}>${svg(i.id)}<span>${i.label}</span>${i.badge?`<span class="nav-badge">${toFa(i.badge)}</span>`:''}</a>`).join('');

document.getElementById('alerts').innerHTML=alerts.map(a=>`<div class="alert-row ${a.type}"><span class="alert-ic">${svg(a.icon,18)}</span><div><div class="alert-t">${a.t}</div><div class="alert-d">${a.d}</div></div></div>`).join('');

document.getElementById('typeGrid').innerHTML=types.map(t=>`<div class="type-card ${t.active?'active':''}"><div class="ti">${svg(t.icon,22)}</div><div class="tn">${t.label}</div></div>`).join('');

function renderSelect(id,items){
  document.getElementById(id).innerHTML=items.map(d=>`
    <div class="sc-item ${d.sel} ${d.active?'active':''} ${d.busy?'busy':''}">
      <span class="sc-avatar">${d.init||svg(d.icon,16)}</span>
      <div class="sc-body"><div class="sc-name">${d.name}</div><div class="sc-sub">${d.sub}</div></div>
      ${d.busy?'<span class="sc-busy-tag">مشغول</span>':''}
    </div>`).join('');
}
renderSelect('doctorList',doctors);
renderSelect('roomList',rooms);
renderSelect('deviceList',devices);


document.getElementById('calHead').innerHTML=weekHead.map(d=>`<span>${d}</span>`).join('');
let calHtml='';
for(let i=0;i<calFirstDayCol;i++) calHtml+='<div class="cal-day empty"></div>';
for(let d=1;d<=calDays;d++){
  const busy=calBusy.includes(d), sel=d===31;
  calHtml+=`<div class="cal-day ${busy?'busy':''} ${sel?'selected':''}">${toFa(d)}</div>`;
}
document.getElementById('calGrid').innerHTML=calHtml;

document.getElementById('slots').innerHTML=slots.map(s=>`<div class="slot ${s.s}">${s.t}</div>`).join('');

// اشغال پزشک
const timeLabels=['','۹','۱۰','۱۱','۱۲','۱۳','۱۴','۱۵','۱۶'];
document.getElementById('schedTimes').innerHTML=timeLabels.map((t,i)=>i===0?'<span class="corner"></span>':`<span>${t}</span>`).join('');
function renderSched(id,rows,withAvatar){
  document.getElementById(id).innerHTML=rows.map(r=>{
    let blocks='';
    r.blocks.forEach(b=>{
      if(b.type==='empty'){ blocks+=`<div class="blk blk-empty" style="grid-column:span ${b.span}"></div>`; }
      else blocks+=`<div class="blk blk-${b.type}" style="grid-column:span ${b.span}">${b.label}</div>`;
    });
    const name=withAvatar
      ? `<div class="sched-name"><span class="sa">${r.init}</span>${r.name}</div>`
      : `<div class="room-name">${svg('pin',14)}${r.name}</div>`;
    return `<div class="sched-row">${name}${blocks}</div>`;
  }).join('');
}
renderSched('doctorSched',docSched,true);
renderSched('roomSched',roomSched,false);

// دستگاه‌ها
document.getElementById('deviceAvail').innerHTML=deviceAvail.map(d=>`
  <div class="dev-item">
    <div class="dev-top"><div><div class="dev-name">${d.name}</div><div class="dev-type">${d.type}</div></div><span class="dev-status ${d.status}">${d.statusL}</span></div>
    <div class="dev-usage"><span class="l">ظرفیت مصرف</span><span class="v">${d.used}</span></div>
    <div class="dev-bar"><div class="dev-fill ${d.fill}" style="width:${d.pct}%"></div></div>
    <div class="dev-maint"><span class="l">سرویس بعدی</span><span class="v">${d.maint}</span></div>
  </div>`).join('');

// لیست‌ها
document.getElementById('recentAppts').innerHTML=recentAppts.map(r=>`<div class="li-row"><span class="li-dot ${r.dot}"></span><div class="li-body"><div class="li-name">${r.name}</div><div class="li-sub">${r.sub}</div></div><span class="li-badge ${r.bcls}">${r.badge}</span></div>`).join('');

function starStr(n){ let s=''; for(let i=0;i<5;i++) s+=i<n?'★':'<span class="empty">★</span>'; return s; }
document.getElementById('treatHistory').innerHTML=treatHistory.map(t=>`<div class="li-row"><div class="li-body"><div class="li-name">${t.name}</div><div class="li-sub">${t.sub}</div></div><span class="stars">${starStr(t.stars)}</span></div>`).join('');

document.getElementById('campHistory').innerHTML=campHistory.map(c=>`<div class="li-row"><span class="li-avatar">${c.init}</span><div class="li-body"><div class="li-name">${c.name}</div><div class="li-sub">${c.sub}</div></div><span class="li-c-badge ${c.bcls}">${c.badge}</span></div>`).join('');

// ستون راست
document.getElementById('todaySchedule').innerHTML=todaySchedule.map(s=>`
  <div class="sched-item ${s.tag||''}">
    <span class="sched-time">${s.time}</span>
    <div class="sched-info"><div class="sched-pt">${s.pt}${s.tag?`<span class="sched-tag ${s.tag}">${s.tagL}</span>`:''}</div><div class="sched-desc">${s.desc}</div></div>
  </div>`).join('');

document.getElementById('weekAhead').innerHTML=weekAhead.map(w=>`
  <div class="week-row"><span class="week-day">${w.day}</span><div class="week-bar"><div class="week-fill ${w.fill}" style="width:${w.pct}%"></div></div><span class="week-count">${toFa(w.count)}</span></div>`).join('');

document.getElementById('quickActions').innerHTML=quickActions.map(q=>`<a href="#" class="qa-item ${q.emergency?'emergency':''}"><span class="qi">${svg(q.icon,18)}</span>${q.label}</a>`).join('');

/* تعامل‌ها */
function makeSelectable(containerId,itemSel){
  const c=document.getElementById(containerId);
  c.addEventListener('click',e=>{
    const item=e.target.closest(itemSel);
    if(!item||item.classList.contains('busy'))return;
    c.querySelectorAll(itemSel).forEach(x=>x.classList.remove('active'));
    item.classList.add('active');
  });
}
makeSelectable('typeGrid','.type-card');
makeSelectable('doctorList','.sc-item');
makeSelectable('roomList','.sc-item');
makeSelectable('deviceList','.sc-item');

// تقویم
document.getElementById('calGrid').addEventListener('click',e=>{
  const d=e.target.closest('.cal-day');
  if(!d||d.classList.contains('empty')||d.classList.contains('busy'))return;
  document.querySelectorAll('.cal-day').forEach(x=>x.classList.remove('selected'));
  d.classList.add('selected');
});
// بازه‌ها
document.getElementById('slots').addEventListener('click',e=>{
  const s=e.target.closest('.slot');
  if(!s||s.classList.contains('booked'))return;
  document.querySelectorAll('.slot').forEach(x=>x.classList.remove('selected'));
  s.classList.add('selected');
});

// دارک‌مود
const html=document.documentElement;
const themeBtn=document.getElementById('themeBtn');
const sun=themeBtn.querySelector('.ic-sun'), moon=themeBtn.querySelector('.ic-moon');
let theme='light';
function applyTheme(t){ theme=t; html.setAttribute('data-theme',t); sun.style.display=t==='dark'?'none':'block'; moon.style.display=t==='dark'?'block':'none'; }
applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light');
themeBtn.addEventListener('click',()=>applyTheme(theme==='light'?'dark':'light'));

// منوی موبایل
const menuToggle=document.getElementById('menuToggle'), overlay=document.getElementById('overlay');
menuToggle.addEventListener('click',()=>html.classList.toggle('nav-open'));
overlay.addEventListener('click',()=>html.classList.remove('nav-open'));
document.querySelectorAll('.nav-item').forEach(n=>n.addEventListener('click',()=>html.classList.remove('nav-open')));

document.addEventListener('DOMContentLoaded', function() {
    const serviceLabels = document.querySelectorAll('#servicesContainer .tchip');
    
    serviceLabels.forEach(label => {
        label.addEventListener('click', function() {
            // حذف کلاس active از همه
            serviceLabels.forEach(l => l.classList.remove('active'));
            
            // اضافه کردن کلاس active به آیتم انتخاب شده
            this.classList.add('active');
            
            // فعال کردن radio input داخل آن
            const radio = this.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        });
    });
});