using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace money
{
    public partial class Form1 : Form
    {
        string m_StrUrl = "https://www.google.com";
        int count = 0;
        public Form1()
        {
            InitializeComponent();
            try
            {
                StreamReader sr = new StreamReader("url.txt");
                while (!sr.EndOfStream)
                {
                    m_StrUrl = sr.ReadLine();
                }
                sr.Close();
            }
            catch
            {

            }

        }

        private void Form1_Load(object sender, EventArgs e)
        {
            webBrowser1.Url = new Uri(m_StrUrl);
            this.WindowState = FormWindowState.Minimized;
            timer1.Enabled = false;
        }

        private void webBrowser1_DocumentCompleted(object sender, WebBrowserDocumentCompletedEventArgs e)
        {

            timer1.Enabled=true;

        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            File.WriteAllText("money.txt", webBrowser1.Document.Body.Parent.OuterHtml, Encoding.GetEncoding(webBrowser1.Document.Encoding));
            this.Close();
        }
    }
}
