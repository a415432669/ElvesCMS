<?php
//--------  Elves网站管理系统”信息提示”语言包（前台）

$qmessage_r=array(
	'CreatePathFail'=>'建立目录不成功，请检查目录权限。',
	'DbError'=>'数据库出错',
	'ErrorUrl'=>'您来自的链接不存在',
	'NotNextInfo'=>'下面没有记录了',
	'NotCanPostUrl'=>'请从网站提交数据',
	'NotCanPostIp'=>'您的IP不在允许提交数据的范围内，所以无法提交',

	'CloseAddNews'=>'此功能已被管理员关闭,有问题请联系管理员',
	'MustLast'=>'您选择的栏目不是终极栏目(蓝色条)',
	'EmptyTitle'=>'请输入标题和内容,并选择栏目',
	'AddNewsSuccess'=>'感谢您的投稿,我们将第一时间审核您的信息',
	'CloseAddNewsTranpic'=>'系统关闭了上传图片功能',
	'EmptyQMustF'=>'请将信息填写完整',
	'HaveNotLevelQInfo'=>'您没有权限管理此信息',
	'ClassSetNotAdminQCInfo'=>'此栏目设置已审核过的信息不能管理',
	'ClassSetNotEditQCInfo'=>'此栏目设置只可编辑未审核信息',
	'ClassSetNotDelQCInfo'=>'此栏目设置只可删除未审核信息',
	'ClassSetNotAdminQInfo'=>'此栏目设置投稿的信息不能管理',
	'ClassSetNotEditQInfo'=>'此栏目设置投稿的信息只能编辑',
	'ClassSetNotDelQInfo'=>'此栏目设置投稿的信息只能删除',
	'EmptyQinfoCid'=>'请选择提交栏目',
	'NotOpenCQInfo'=>'此栏目未开放投稿',
	'HaveNotLevelAQinfo'=>'您所属的会员组不能提交信息',
	'HaveNotFenAQinfo'=>'您的点数不足,不能提交信息',
	'AddQinfoSuccess'=>'提交信息成功',
	'EditQinfoSuccess'=>'修改信息成功',
	'DelQinfoSuccess'=>'删除信息成功',
	'EmptyQTranFile'=>'请选择要上传的文件',
	'NotQTranFiletype'=>'您上传的文件扩展名有误',
	'CloseQTranPic'=>'系统关闭上传图片功能',
	'TooBigQTranFile'=>'您上传的文件大小超过系统限制',
	'CloseQTranFile'=>'系统关闭了上传附件功能',
	'CloseQAdd'=>'系统关闭投稿功能',
	'HaveCloseWords'=>'您提交的信息含有非法字符',
	'ReIsOnlyF'=>'字段 '.$GLOBALS['msgisonlyf'].' 的值已存在，请不要重复提交',
	'NewMemberAddInfoError'=>'系统限制新注册会员 '.$public_r['newaddinfotime'].' 分钟后才能投稿',
	'CrossDayInfo'=>'您今天的投稿次数已超过系统限制',
	'TranFail'=>'请查看目录权限是否为0777,文件上传不成功',
	'QAddInfoOutTime'=>'系统限制的投稿间隔是 '.$public_r[readdinfotime].' 秒,请稍后再提交',
	'QEditInfoOutTime'=>'信息发布超过 '.$public_r[qeditinfotime].' 分钟不能修改',
	'IpMaxAddInfo'=>'您的投稿过于频繁，请稍后再提交',

	'NotVote'=>'此投票不存在!',
	'VoteOutDate'=>'此投票已过期.投票不成功!',
	'ReVote'=>'此IP已投票过,请勿重复投票!',
	'EmptyChangeVote'=>'请至少选择一个投票项',
	'NotChangeVote'=>'您还没有选择投票项',
	'VoteSuccess'=>'感谢您的投票',
	'EmptyPl'=>'请输入评论内容',
	'EmptyPlMustF'=>'字段 '.$GLOBALS['msgmustf'].' 的值为空，请将必填项填写完整',
	'PlOutTime'=>'系统限制的发表评论间隔是 '.$GLOBALS['setpltime'].' 秒,请稍后再发',
	'VoteOutTime'=>'系统限制的发表投票间隔是 '.$public_r[revotetime].' 秒,请稍后再投',
	'GbOutTime'=>'系统限制的发表留言间隔是 '.$public_r[regbooktime].' 秒,请稍后再发',
	'HavePlCloseWords'=>'评论内容含有非法字符',
	'NotLevelToPl'=>'您所在的会员组不能发表评论',
	'PlOutMaxFloor'=>'引用楼层数已超过限制',
	'GuestNotToPl'=>'游客不能发表评论',
	'CloseClassPl'=>'此栏目已关闭评论功能',
	'CloseInfoPl'=>'此信息已关闭评论',
	'AddPlSuccess'=>'增加评论成功',
	'PlSizeTobig'=>'您的评论内容过长，系统不接受（系统限制 '.$GLOBALS['setplsize'].' 字节）',
	'EmptyGbookname'=>'请输入留言姓名,邮箱与留言内容',
	'AddGbookSuccess'=>'留言发布完毕!',
	'EmptyFeedbackname'=>'带*项为必填',
	'AddFeedbackSuccess'=>'信息反馈成功!',
	'AddErrorSuccess'=>'感谢您的报告，我们会尽快处理此事',
	'EmptyErrortext'=>'请输入错误报告内容',
	'EmptyGbook'=>'此留言板不存在',
	'EmptyFeedback'=>'此信息反馈不存在',
	'DoForPlGSuccess'=>'谢谢您的支持',
	'DoForPlBSuccess'=>'谢谢您的意见',
	'ReDoForPl'=>'您已提交过',
	'AddInfoPfen'=>'感谢您的评价',
	'DoDiggGSuccess'=>'谢谢您的支持',
	'DoDiggBSuccess'=>'谢谢您的意见',
	'ReDigg'=>'您已提交过',
	'NotOpenFBFile'=>'系统未开启附件上传',
	'NotLevelToClass'=>'您所在的会员组没有权限访问此栏目',
	'ThisTimeCloseDo'=>'本时间段内不允许使用此操作',
	'NotOpenMemberConnect'=>'网站没有开启外部登录',

	'CloseRegister'=>'管理员已关闭注册',
	'EmptyMember'=>'用户名，密码与邮箱不能为空',
	'FaiUserlen'=>'用户名长度有误',
	'FailPasslen'=>'密码位数不够或过长',
	'NotRepassword'=>'二次密码不一致',
	'EmailFail'=>'您输入的邮箱有误!',
	'ReEmailFail'=>'此邮箱已被注册',
	'RegisterReIpError'=>'同一IP不能重复注册',
	'RegHaveCloseword'=>'用户名包含禁用字符',
	'NotSpeWord'=>'用户名不能包含特殊字符',
	'ReUsername'=>'此用户名已被注册，请重填！',
	'LoginToRegister'=>'您已登录，不能注册帐号',
	'RegisterSuccess'=>'注册成功',
	'RegisterSuccessCheck'=>'注册成功，请等待管理员的审核',
	'NotEmpty'=>'带*项的为必填',
	'FailOldPassword'=>'原密码错误，无法修改',
	'EditInfoSuccess'=>'修改信息成功！',
	'NotLogin'=>'您还没登录!',
	'NotSingleLogin'=>'同一帐号同一时刻只能一人在线!',
	'NotCheckedUser'=>'您的帐号还未通过审核',
	'ExitSuccess'=>'退出系统成功！',
	'EmptyLogin'=>'用户名和密码不能为空',
	'FailPassword'=>'您的用户名或密码有误!',
	'LoginSuccess'=>'登录成功!',
	'NotCookie'=>'登录不成功，请确认您的cookie是否已开启!',
	'MoreFava'=>'您的收藏夹已满，增加收藏不成功',
	'AddFavaSuccess'=>'增加收藏夹成功',
	'ReFava'=>'此收藏链接已存在',
	'NotDelFavaid'=>'请选择要删除的收藏夹',
	'DelFavaSuccess'=>'删除收藏夹成功',
	'EmptyFavaClassname'=>'请输入分类名称',
	'AddFavaClassSuccess'=>'增加分类成功',
	'EditFavaClassSuccess'=>'修改分类成功',
	'EmptyFavaClassid'=>'请选择要删除的分类',
	'DelFavaClassSuccess'=>'删除分类成功',
	'NotChangeMoveCid'=>'请选择要转移的分类',
	'NotMoveFavaid'=>'请至少选择一个要转移的收藏夹',
	'MoveFavaSuccess'=>'转移收藏夹成功',
	'EmptyGetCard'=>'请输入充值的用户名,卡号和密码',
	'DifCardUsername'=>'两次输入的用户名不一致!',
	'ExiestCardUsername'=>'您输入的用户名不存在！请查看你输入的用户名是否有误。',
	'CardPassError'=>'您输入的充值卡号或密码有误。充值不成功！',
	'CardGetFenSuccess'=>'恭喜您！充值成功',
	'CardGetFenError'=>'数据库忙，请稍后再充值，谢谢!',
	'CardOutDate'=>'此点卡已过期,充值不成功',
	'FailKey'=>'验证码不正确',
	'OutKeytime'=>'验证码已过期',
	'EmptyMsg'=>'请输入标题、消息内容与发送目标',
	'MsgToself'=>'不能发给自己!',
	'MoreMsglen'=>'内容过长,发送不成功',
	'MsgNotToUsername'=>'接收者帐号不存在!',
	'UserMoreMsgnum'=>'对方短消息已满，发送不成功!',
	'AddMsgSuccess'=>'短消息发送成功!',
	'EmptyDelMsg'=>'请选择要删除的短消息',
	'DelMsgSuccess'=>'删除短消息成功',
	'HaveNotMsg'=>'此消息不存在',
	'HaveNotEnLevel'=>'权限不足',
	'NotUsername'=>'此帐号不存在',
	'NotLevelShowInfo'=>'您没有足够的权限查看会员信息',
	'NotLevelMemberList'=>'您没有足够的权限查看会员列表',
	'EmptyFriend'=>'请输入用户名',
	'NotFriendUsername'=>'此帐号不存在',
	'AddFriendSuccess'=>'添加好友成功',
	'EditFriendSuccess'=>'修改好友成功',
	'EmptyFriendId'=>'请选择要删除的好友',
	'DelFriendSuccess'=>'删除好友成功',
	'NotAddFriendSelf'=>'不能加自己为好友',
	'ReAddFriend'=>'此用户已在你的好友列表里',
	'NotChangeSpaceStyleId'=>'请选择要设置的空间模板',
	'ChangeSpaceStyleSuccess'=>'设置空间模板成功',
	'SetSpaceSuccess'=>'设置空间信息成功',
	'CloseMemberSpace'=>'系统已关闭会员空间功能',
	'EmptyMemberGbook'=>'请输入昵称与留言内容',
	'AddMemberGbookSuccess'=>'留言完毕',
	'NotDelMemberGbookid'=>'请选择要删除的留言',
	'DelMemberGbookSuccess'=>'删除留言成功',
	'EmptyReMemberGbook'=>'请输入要回复的留言',
	'ReMemberGbookSuccess'=>'留言回复完毕',
	'EmptyMemberFeedback'=>'请输入联系人、信息标题与信息内容',
	'AddMemberFeedbackSuccess'=>'信息提交成功',
	'NotDelMemberFeedbackid'=>'请选择要删除的反馈',
	'DelMemberFeedbackSuccess'=>'删除成功',
	'EmptyGetPassword'=>'请输入用户名和邮箱',
	'ErrorGPUsername'=>'用户名或邮箱不正确',
	'CloseGetPassword'=>'网站已关闭取回密码功能',
	'SendGetPasswordEmailSucess'=>'邮件已发送，请登录邮箱认证并取回密码',
	'GPOutTime'=>'链接已过期',
	'GPErrorPass'=>'参数不正确，验证不通过',
	'GetPasswordSuccess'=>'取回密码成功',
	'ActUserSuccess'=>'帐号已成功激活',
	'SendActUserEmailSucess'=>'激活帐号邮件已发送，请登录邮箱激活帐号',
	'CloseRegAct'=>'网站没有启用邮件激活帐号方式',
	'EmptyRegAct'=>'请输入用户名、密码和邮箱',
	'ErrorRegActUser'=>'用户名、密码或邮箱不正确',
	'HaveRegActUser'=>'此帐号已激活过',
	
	'SearchNotRecord'=>'没有搜索到相关的内容',
	'SearchOutTime'=>'系统限制的搜索时间间隔为 '.$public_r[searchtime].' 秒,请稍后再搜索',
	'EmptyKeyboard'=>'请输入搜索关键字',
	'MinKeyboard'=>'系统限制的搜索关键字只能在 '.$public_r[min_keyboard].'~'.$public_r[max_keyboard].' 个字符之间',
	'NotLevelToSearch'=>'您所在的会员组没有权限使用搜索功能',

	'FailDownpass'=>'下载验证码不正确,请重新刷新下载页面,然后在点击下载.',
	'ExiestSoftid'=>'此下载不存在',
	'MustSingleUser'=>'同时只能一人在线,请重新登录',
	'NotDownLevel'=>'您的会员级别不足，没有下载此软件的权限!',
	'NotEnoughFen'=>'您的点数不足，无法下载此软件',
	'CrossDaydown'=>'您今天的下载与观看次数已超过系统限制',
	'CloseGetDown'=>'没有开启直接下载',
	
	'NotChangeProduct'=>'此商品不存在',
	'MustEnterSelect'=>'带*项为必填，请填写完整',
	'EmptyBuycar'=>'您的购物车无任何商品',
	'NotPsid'=>'请选择配送方式',
	'NotPayfsid'=>'请选择付款方式',
	'NotProductForBuyfen'=>'您选择的商品不支持积分购买',
	'NotEnoughFenBuy'=>'您的点数不足,不能通过点数购买商品',
	'NotLoginTobuy'=>'您未登录,不能使用此付费方式',
	'NotEnoughMoneyBuy'=>'您的帐号余额不足,不能购买商品',
	'AddDdSuccess'=>'订单提交成功.',
	'AddDdSuccessa'=>'订单提交成功.',
	'AddDdAndToPaySuccess'=>'订单提交成功，正转向在线支付...',
	'FenNotFp'=>'积分购买不开发票',
	'NotShopDdId'=>'此订单不存在',
	'ShopDdIdHavePrice'=>'此订单已经支付',
	'EmptyAddress'=>'请输入地址名称',
	'AddAddressSuccess'=>'增加地址成功',
	'EditAddressSuccess'=>'修改地址成功',
	'NotAddressid'=>'请选择地址',
	'DelAddressSuccess'=>'删除地址成功',
	'DefAddressSuccess'=>'设置默认地址成功',
	'ErrorShopTbname'=>'非商城表的信息',
	'NotChangeShopDdid'=>'请选择订单',
	'NotDelShopDd'=>'此订单已确认，不能取消',
	'OuttimeNotDelShopDd'=>'此订单下单时间已超过可取消时间',
	'DelShopDdSuccess'=>'取消订单成功',
	'EmptyPreCode'=>'此优惠码不存在',
	'PreCodeOuttime'=>'此优惠码已过期',
	'PreCodeNotLevel'=>'您所在的会员组没有权限使用此优惠码',
	'PreCodeErrorClass'=>'此类商品不能使用此优惠码',
	'PreCodeMusttotal'=>'购满 '.$GLOBALS['precodemusttotal'].' 元才可以使用此优惠码',
	'ShopOutMaxnum'=>'您购买的商品数量已超过库存量',
	'ShopNotProductNum'=>'此商品目前无货',
	'ShopDdCancel'=>'此订单已经取消',
	'ShopBuycarMaxnum'=>'您的购物车商品数量超过限制',
	'ShopOutSinglenum'=>'您购买的单商品总数已超过限制',

	'SchallNotRecord'=>'没有搜索到相关的内容',
	'SchallOutTime'=>'系统限制的搜索时间间隔为 '.$public_r[schalltime].' 秒,请稍后再搜索',
	'EmptySchallKeyboard'=>'请输入搜索关键字',
	'SchallMinKeyboard'=>'系统限制的搜索关键字只能在 '.$public_r[schallminlen].'~'.$public_r[schallmaxlen].' 个字符之间',
	'SchallNotOpenTitleText'=>'系统未开启标题+全文同时搜索',
	'SchallNotOpenTitle'=>'系统未开启标题搜索',
	'SchallNotOpenText'=>'系统未开启全文搜索',
	'SchallClose'=>'全站搜索未开启',

	'CloseTags'=>'TAG功能已关闭',
	'HaveNotTags'=>'此TAG不存在',
);
?>