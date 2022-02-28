const navLinkArray = [
  {
    name: 'connect',
    name_jp: '接続',
    icon: '<i class="fas fa-link"></i>',
    subLinkArray: ''
  },
  {
    name: 'user',
    name_jp: '学生データ',
    icon: '<i class="fas fa-users"></i>',
    subLinkArray: [
      {name: 'create', name_jp: '登録'},
      {name: 'index', name_jp: '一覧'},
    ]
  },
  {
    name: 'schedule',
    name_jp: 'スケジュールデータ',
    icon: '<i class="fas fa-calendar-alt"></i>',
    subLinkArray: [
      {name: 'create', name_jp: '登録'},
      {name: 'index', name_jp: '一覧'},
    ]
  },
  {
    name: 'log',
    name_jp: 'ログデータ',
    icon: '<i class="fas fa-database"></i>',
    subLinkArray: [
      {name: 'index', name_jp: '一覧'},
    ]
  },
];

const gradeArray = {
  '1EC': {
    team: false,
    schedule: 'type03'
  },
  '2EC': {
    team: true,
    schedule: 'type02'
  },
  '3EC': {
    team: true,
    schedule: 'type02'
  },
  '2NC': {
    team: true,
    schedule: 'type03'
  },
  '3NC': {
    team: true,
    schedule: 'type02'
  },
};