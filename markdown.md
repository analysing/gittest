[文件](https://markdown.tw)
[资源](https://markdown.tw/resources.html)
[标准](commonmark.org)
[错误报告][err_report]

[err_report]:https://github.com/othree/markdown-syntax-zhtw/issues

# Markdown文件
![markdown][8xian]

[8xian]:https://markdown.tw/images/208x128.png

**Note**: This is Traditional Chinese Edition Document of Markdown Syntax. If you are seeking for English Edition Document. Please refer to [Markdown: Syntax](http://daringfireball.net/projects/markdown/syntax).

---
# Markdown: Syntax
+ [概述](https://markdown.tw/#overview)
  - [哲学](https://markdown.tw/#philosophy)
  - [行内HTML](https://markdown.tw/#html)
  - [特殊字符自动转换](https://markdown.tw/#autoescape)
+ [区块元素](https://markdown.tw/#block)
  - [段落和换行](https://markdown.tw/#p)
  - [标题](https://markdown.tw/#header)
  - [区块引用](https://markdown.tw/#blockquote)
  - [清单](https://markdown.tw/#list)
  - [代码区块](https://markdown.tw/#precode)
  - [分隔线](https://markdown.tw/#hr)
+ [区段元素](https://markdown.tw/#span)
  - [链接](https://markdown.tw/#link)
  - [强调](https://markdown.tw/#em)
  - [代码](https://markdown.tw/#code)
  - [图片](https://markdown.tw/#img)
+ [其他](https://markdown.tw/#misc)
  - [转义字符](https://markdown.tw/#backslash)
  - [自动链接](https://markdown.tw/#autolink)
+ [感谢](https://markdown.tw/#acknowledgement)

**注意：** 这份文件是用Markdown写的,你可以看看它的[原始文档](https://github.com/othree/markdown-syntax-zhtw/blob/master/syntax.md)

---
# 概述
## 哲学

Markdown的目标是实现「易读易写」。

不过最需要强调的是它的已读性。一份使用Markdown撰写的文件应该可以直接以纯文本发布，并且看起来不会像是由许多标签或是格式指令所构成。Markdown语法受到一些既有text-to-html格式的影响，包括[select](http://docutils.sourceforge.net/mirror/setext.html)、[atx](http://www.aaronsw.com/2002/atx/)、[textile](http://textism.com/tools/textile/)、[reStructuredText](http://docutils.sourceforge.net/rst.html)、[Grutatext](http://www.triptico.com/software/grutatxt.html)和[EtText](http://ettext.taint.org/doc/)，然而最大的灵感其实来自纯文本的电子邮件格式。

因此Markdown的语法全由标点符号所组成，并经过严谨慎选，是为了让它们看起来就像所要表达的意思。像是在文字两旁加上星号，看起来就像*强调*。Markdown的清单看起来，嗯，就是清单。加入你有使用过电子邮件，区块引用看起来就真的像是引用一段文字。

## 行内HTML
Markdown的语法有个主要的目的：用来作为一种网络内容的*写作*用语言。

Markdown不是用来取代HTML，甚至也没有要和它相似，它的语法种类不多，只和HTML的一部分有关系，重点*不是*要创造一种更容易写作HTML文件的语法，我认为HTML已经很容易写了，Markdown的重点在于，它能让文件更容易阅读、编写。HTML 是一种发布的格式，Markdown是一种编写的格式，因此，Markdown的格式语法只涵盖纯文字可以涵盖的范围。

不在Markdown涵盖范围之外的标签，都可以直接在文件里面用HTML撰写。不需要额外标注这是HTML或是Markdown；只要直接加标签就可以了。

只有区块元素——比如`<div>`、`<table>`、`<pre>`、`<p>`等标签，必需在前后加上空行，以利与内容区隔。而且这些（元素）的开始与结尾标签，不可以用tab或是空白来缩排。Markdown的产生器有智慧型判断，可以避免在区块标签前后加上没有必要的`<p>`标签。

举例来说，在Markdown文件里加上一段HTML表格：
```
This is a regular paragraph.

<table>
    <tr>
        <td>Foo</td>
    </tr>
</table>

This is another regular paragraph.
```

请注意，Markdown语法在HTML区块标签中将不会被进行处理。例如，你无法在HTML区块内使用Markdown形式的*强调*。

HTML的区段标签如`<span>`、`<cite>`、`<del>`则不受限制，可以在Markdown的段落、清单或是标题里任意使用。依照个人习惯，甚至可以不用Markdown格式，而采用HTML标签来格式化。举例说明：如果比较喜欢HTML的`<a>`或`<img>`标签，可以直接使用这些标签，而不用Markdown提供的链接或是影像标识语法。

HTML区段标签和区块标签不同，在区段标签的范围内，Markdown的语法是有效的。

## 特殊字符自动转换

在HTML文件中，有两个字符需要特殊处理：<和&。<符号用于起始标签&符号则用于标记HTML实体，如果你只是想要使用这些符号，你必需要使用实体的形式，像是`&lt;`和`&amp;`。

& 符号其实很容易让协作网络文件的人感到困扰，如果你要打「AT&T」，你必须要写成「AT&amp;T」，还得转换网址内的 & 符号，如果你要链接到：

`http://images.google.com/images?num=30&q=larry+bird`

你必须要把网址转换成：

`http://images.google.com/images?num=30&amp;q=larry+bird`

才能放到链接标签的href属性里。不用说也知道这很容易忘记，这也可能是HTML标准检查所检查到的错误中，数量最多的。

Markdown允许你直接使用这些符号，但是你要小心跳脱字元的使用，如果你是在HTML试题中使用&符号的话，它不会被转换，而在其他情形下，它则会被转换成`&amp;`。所以你如果要在文件中插入一个著作权的符号，你可以这样写：

`&copy;`

Markdown将不会对这段文字做修改，但是如果你这样写：

`AT&T`

Markdown就会将它转为：

`AT&amp;T`

类似的状况也会发生在<符号上，因为Markdown支援[行内 HTML](https://markdown.tw/#html)，如果你是使用<符号作为HTML标签使用，那Markdown也不会对它做任何转换，但是如果你是写：

`4 < 5`

Markdown将会把它转换为：

`4 &lt; 5`

不过需要注意的是，code范围内，不论是行内还是区块，<和&两个符号都一定会被转换成HTML实体，这项特性让你可以很容易地用Markdown写HTML code（和HTML相对而言。在HTML语法中，你要把所有的<和&都转换为HTML实体，才能在HTML文件里面写出HTML code。）

---

# 区块元素
## 段落和换行

一个段落是由一个以上相连接的行句组成，而一个以上的空行则会切分出不同的段落（空行的定义是显示上看起来像是空行，变回被视为空行。比方说，若某一行只包含空白和tab，则该行也会被视为空行），一般的段落不需要用空白或断行缩排。

「一个以上相连接的行句组成」这句话其实俺是了Markdown允许段落内的强迫断行，这个特性和其他大部分的text-to-HTML格式不一样（包括 MovableType的 「Convert Line Breaks」选项），其他的格式会把每个断行都转成`<br />`标签。

如果你真的想要插入`<br />`标签的话，在行尾加上两个以上的空白，然后按enter。

是的，这确实需要花比较多功夫来插入`<br />`，但是「每个换行都转换为`<br />`」的方法在Markdown中并不适合，Markdown中email式的[区块引用](https://markdown.tw/#blockquote)和多段落的[清单](https://markdown.tw/#list)在使用换行来排版的时候，不但更好用，还更好阅读。

## 标题

## 表格

|name|hobby|gender|birth|
|:---|---:|---|:---:|
|左对齐|右对齐|左对齐|中间对齐|
|bill|sleep|male|8.6|
|ivy|play game|female|5.1|
|admin|unknow|male|1.1|
|sa|unknow|male|1.1|
|root|unknow|male|1.1|
|8xian|eat|female|5.1|
|xiaolu|smile|female|5.1|


<table>
<tr>
<th>name</th>
<th>hobby</th>
<th>gender</th>
<th>birth</th>
</tr>
<tr>
<td>左对齐</td>
<td align="right">右对齐</td>
<td>左对齐</td>
<td align="center">中间对齐</td>
</tr>
<tr>
<td>bill</td>
<td>sleep</td>
<td>male</td>
<td align="center">8.6</td>
</tr>
<tr>
<td>ivy</td>
<td>play game</td>
<td>female</td>
<td>5.1</td>
</tr>
<tr>
<td>admin</td>
<td>unknow</td>
<td>male</td>
<td>1.1</td>
</tr>
<tr>
<td>sa</td>
<td>unknow</td>
<td>male</td>
<td>1.1</td>
</tr>
<tr>
<td>root</td>
<td>unknow</td>
<td>male</td>
<td>1.1</td>
</tr>
<tr>
<td>8xian</td>
<td>eat</td>
<td>female</td>
<td>5.1</td>
</tr>
<tr>
<td>xiaolu</td>
<td>smile</td>
<td>female</td>
<td>5.1</td>
</tr>
</table>